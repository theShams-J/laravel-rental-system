<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use App\Models\RMS\Maintenance;
use App\Models\RMS\Apartment;
use App\Models\RMS\User;
use App\Models\RMS\Invoice;
use App\Models\RMS\InvoiceDetail;
use App\Models\RMS\Lease;
use App\Models\RMS\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of maintenance records.
     */
    public function index(Request $request)
    {
        $query = Maintenance::with(['apartment.building', 'reportedBy']);
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $maintenance = $query->paginate(15);
        
        return view('pages.maintenance.index', compact('maintenance'));
    }

    /**
     * Show the form for creating a new maintenance record.
     */
    public function create()
    {
        $apartments = Apartment::with('building')->get();
        $users = User::all();
        
        return view('pages.maintenance.create', compact('apartments', 'users'));
    }

    /**
     * Store a newly created maintenance record in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => 'required|exists:rms_apartments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High,Urgent',
            'cost_bearer' => 'required|in:company,tenant',
            'vendor_name' => 'nullable|string|max:255',
            'vendor_mobile' => 'nullable|string|max:20',
            'scheduled_at' => 'nullable|date',
            'photo_before' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['company_id'] = Auth::user()->company_id;
        $validated['status'] = 'Open';
        $validated['is_billed'] = 0;
        $validated['reported_by'] = Auth::id();
        $validated['created_by'] = Auth::id();

        // Handle photo_before upload
        if ($request->hasFile('photo_before')) {
            $maintenance = new Maintenance();
            $maintenance->fill($validated);
            $maintenance->save();
            
            $imageName = $maintenance->id . '_before.' . $request->photo_before->extension();
            $request->photo_before->move(public_path('img/maintenance'), $imageName);
            $maintenance->update(['photo_before' => $imageName]);
        } else {
            $maintenance = Maintenance::create($validated);
        }

        // Notify admins about new maintenance request
        $admins = User::where('company_id', $maintenance->company_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->get();

        foreach ($admins as $admin) {
            Notification::create([
                'company_id' => $maintenance->company_id,
                'user_id' => $admin->id,
                'type' => 'maintenance_new',
                'message' => "New maintenance request: {$maintenance->title} for {$maintenance->apartment->apartment_no}",
                'url' => route('maintenance.show', $maintenance->id),
            ]);
        }

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record created successfully.');
    }

    /**
     * Display the specified maintenance record.
     */
    public function show($id)
    {
        $maintenance = Maintenance::with([
            'apartment.building',
            'reportedBy',
            'assignedTo',
            'resolvedBy',
            'invoice'
        ])->findOrFail($id);

        return view('pages.maintenance.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified maintenance record.
     */
    public function edit($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $apartments = Apartment::with('building')->get();
        $users = User::all();

        return view('pages.maintenance.edit', compact('maintenance', 'apartments', 'users'));
    }

    /**
     * Update the specified maintenance record in database.
     */
    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High,Urgent',
            'status' => 'required|in:Open,In Progress,Resolved,Cancelled',
            'vendor_name' => 'nullable|string|max:255',
            'vendor_mobile' => 'nullable|string|max:20',
            'scheduled_at' => 'nullable|date',
            'assigned_to' => 'nullable|exists:rms_users,id',
        ]);

        $validated['updated_by'] = Auth::id();

        $oldStatus = $maintenance->status;
        $maintenance->update($validated);

        // Notify admins if status changed
        if ($oldStatus !== $maintenance->status) {
            $admins = User::where('company_id', $maintenance->company_id)
                ->whereHas('role', function ($query) {
                    $query->where('name', 'admin');
                })
                ->get();

            foreach ($admins as $admin) {
                Notification::create([
                    'company_id' => $maintenance->company_id,
                    'user_id' => $admin->id,
                    'type' => 'maintenance_status',
                    'message' => "Maintenance status updated: {$maintenance->title} - {$oldStatus} → {$maintenance->status}",
                    'url' => route('maintenance.show', $maintenance->id),
                ]);
            }
        }

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record updated successfully.');
    }

    /**
     * Show form to resolve a maintenance record.
     */
    public function resolveForm($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        return view('pages.maintenance.resolve', compact('maintenance'));
    }

    /**
     * Resolve a maintenance record.
     */
    public function resolve(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'cost' => 'required|numeric|min:0',
            'photo_after' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Handle photo_after upload
        $photoAfter = $maintenance->photo_after;
        if ($request->hasFile('photo_after')) {
            $imageName = $maintenance->id . '_after.' . $request->photo_after->extension();
            $request->photo_after->move(public_path('img/maintenance'), $imageName);
            $photoAfter = $imageName;
        }

        $maintenance->update([
            'status' => 'Resolved',
            'resolved_at' => now(),
            'cost' => $validated['cost'],
            'photo_after' => $photoAfter,
            'resolved_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('maintenance.show', $maintenance->id)->with('success', 'Maintenance marked as resolved.');
    }

    /**
     * Show form to bill a maintenance record.
     */
    public function billForm($id)
    {
        $maintenance = Maintenance::findOrFail($id);

        if ($maintenance->is_billed == 1 || $maintenance->status !== 'Resolved' || $maintenance->cost_bearer !== 'tenant') {
            return redirect()->route('maintenance.show', $id)->with('error', 'Maintenance is not ready for billing.');
        }

        $lease = Lease::where('apartment_id', $maintenance->apartment_id)
            ->where('status', 'active')
            ->latest()
            ->first();

        $pendingInvoice = null;
        if ($lease) {
            $pendingInvoice = Invoice::where('lease_id', $lease->id)
                ->where('status', 'Pending')
                ->latest()
                ->first();
        }

        return view('pages.maintenance.bill', compact('maintenance', 'pendingInvoice'));
    }

    /**
     * Bill a resolved maintenance to tenant.
     */
    public function bill(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        if ($maintenance->is_billed == 1) {
            return redirect()->route('maintenance.show', $id)->with('error', 'This maintenance has already been billed.');
        }

        if ($maintenance->status !== 'Resolved') {
            return redirect()->route('maintenance.show', $id)->with('error', 'Only resolved maintenance can be billed.');
        }

        if ($maintenance->cost_bearer !== 'tenant') {
            return redirect()->route('maintenance.show', $id)->with('error', 'Only tenant-billed maintenance can be charged.');
        }

        $validated = $request->validate([
            'charge_method' => 'required|in:next_invoice,separate_invoice',
            'cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $chargeMethod = $validated['charge_method'];
        $cost = $validated['cost'];
        $notes = $validated['notes'] ?? null;

        $lease = Lease::where('apartment_id', $maintenance->apartment_id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$lease) {
            return redirect()->back()->withInput()->with('error', 'No active lease found for this apartment.');
        }

        if ($chargeMethod === 'next_invoice') {
            $invoice = Invoice::where('lease_id', $lease->id)
                ->where('status', 'Pending')
                ->latest()
                ->first();

            if (!$invoice) {
                return redirect()->back()->withInput()->with('error', 'No pending invoice found for this tenant. Please create a monthly invoice first, or use Separate Invoice option.');
            }
        }

        DB::transaction(function () use ($maintenance, $chargeMethod, $cost, $notes, $lease, &$invoice) {
            $maintenance->update(['cost' => $cost]);

            if ($chargeMethod === 'next_invoice') {
                $nextSort = InvoiceDetail::where('invoice_id', $invoice->id)->max('sort_order') ?? 0;

                InvoiceDetail::create([
                    'company_id' => Auth::user()->company_id,
                    'invoice_id' => $invoice->id,
                    'description' => 'Maintenance Charge: ' . $maintenance->title,
                    'price' => $cost,
                    'qty' => 1,
                    'vat' => 0,
                    'discount' => 0,
                    'sort_order' => $nextSort + 1,
                ]);

                $invoice->update([
                    'amount' => $invoice->amount + $cost,
                    'updated_by' => Auth::id(),
                ]);

                $maintenance->update([
                    'is_billed' => 1,
                    'charge_method' => 'next_invoice',
                    'invoice_id' => $invoice->id,
                    'updated_by' => Auth::id(),
                ]);

                return;
            }

            $invoice = Invoice::create([
                'company_id' => Auth::user()->company_id,
                'lease_id' => $lease->id,
                'tenant_id' => $lease->tenant_id,
                'amount' => $cost,
                'invoice_date' => now()->toDateString(),
                'due_date' => now()->addDays(7)->toDateString(),
                'period' => 'Maintenance — ' . $maintenance->title,
                'status' => 'Pending',
                'notes' => $notes,
                'created_by' => Auth::id(),
            ]);

            InvoiceDetail::create([
                'company_id' => Auth::user()->company_id,
                'invoice_id' => $invoice->id,
                'description' => 'Maintenance Charge: ' . $maintenance->title,
                'price' => $cost,
                'qty' => 1,
                'vat' => 0,
                'discount' => 0,
                'sort_order' => 1,
            ]);

            $maintenance->update([
                'is_billed' => 1,
                'charge_method' => 'separate_invoice',
                'invoice_id' => $invoice->id,
                'updated_by' => Auth::id(),
            ]);
        });

        if ($chargeMethod === 'next_invoice') {
            return redirect()->route('maintenance.show', $id)->with('success', 'Maintenance billed to tenant on the next invoice successfully.');
        }

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Separate maintenance invoice created successfully.');
    }

    /**
     * Show deletion confirmation.
     */
    public function delete($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        return view('pages.maintenance.delete', compact('maintenance'));
    }

    /**
     * Remove the specified maintenance record from database (soft delete).
     */
    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('maintenance.index')->with('success', 'Maintenance record deleted successfully.');
    }
}
