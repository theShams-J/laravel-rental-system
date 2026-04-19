<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Lease;
use App\Models\RMS\Apartment;
use App\Models\RMS\Tenant;

class LeaseController extends Controller
{
    public function index()
    {
        $leases = Lease::with(['tenant', 'apartment.building'])
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('pages.lease.index', compact('leases'));
    }

    public function create(Request $request)
    {
        $apartments = Apartment::where('status', 'Available')->get();
        $tenants    = Tenant::where('is_active', 1)->get();
        $selectedApartmentId = $request->query('apartment_id');
        $selectedTenantId    = $request->query('tenant_id');

        return view('pages.lease.create', compact(
            'apartments', 'tenants', 'selectedApartmentId', 'selectedTenantId'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_id'    => 'required',
            'apartment_id' => 'required',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after:start_date',
            'monthly_rent' => 'required|numeric',
        ]);

        Lease::create([
            'company_id'         => Auth::user()->company_id,
            'tenant_id'          => $request->tenant_id,
            'apartment_id'       => $request->apartment_id,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'monthly_rent'       => $request->monthly_rent,
            'security_deposit'   => $request->security_deposit,
            'rent_due_day'       => $request->rent_due_day ?? 1,
            'grace_period_days'  => $request->grace_period_days ?? 5,
            'late_fee_amount'    => $request->late_fee_amount ?? 0,
            'notice_period_days' => $request->notice_period_days ?? 30,
            'status'             => 'Active',
            'created_by'         => Auth::id(),
        ]);

        // Mark apartment as Occupied
        Apartment::where('id', $request->apartment_id)
            ->update(['status' => 'Occupied', 'updated_by' => Auth::id()]);

        return redirect()->route('leases.index')->with('success', 'Lease created successfully.');
    }

    public function show(Lease $lease)
    {
        $lease->load(['tenant', 'apartment.building', 'invoices.receipts']);
        return view('pages.lease.show', compact('lease'));
    }

    public function edit(Lease $lease)
    {
        $apartments = Apartment::all();
        $tenants    = Tenant::where('is_active', 1)->get();
        return view('pages.lease.edit', compact('lease', 'apartments', 'tenants'));
    }

    public function update(Request $request, Lease $lease)
    {
        $request->validate([
            'tenant_id'    => 'required',
            'apartment_id' => 'required',
            'start_date'   => 'required|date',
            'monthly_rent' => 'required|numeric',
        ]);

        $lease->update([
            'tenant_id'          => $request->tenant_id,
            'apartment_id'       => $request->apartment_id,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'monthly_rent'       => $request->monthly_rent,
            'security_deposit'   => $request->security_deposit,
            'rent_due_day'       => $request->rent_due_day ?? 1,
            'grace_period_days'  => $request->grace_period_days ?? 5,
            'status'             => $request->status,
            'updated_by'         => Auth::id(),
        ]);

        return redirect()->route('leases.index')->with('success', 'Lease updated successfully.');
    }

    public function delete($id)
    {
        $lease = Lease::with(['tenant', 'apartment'])->findOrFail($id);
        return view('pages.lease.delete', compact('lease'));
    }

    public function destroy(Lease $lease)
    {
        // Free up the apartment
        Apartment::where('id', $lease->apartment_id)
            ->update(['status' => 'Available', 'updated_by' => Auth::id()]);

        $lease->update([
            'status'            => 'Terminated',
            'terminated_at'     => now(),
            'updated_by'        => Auth::id(),
        ]);

        return redirect()->route('leases.index')->with('success', 'Lease terminated successfully.');
    }
}
