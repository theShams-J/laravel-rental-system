<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Invoice;
use App\Models\RMS\InvoiceDetail;
use App\Models\RMS\Lease;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['tenant', 'lease', 'receipts'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $invoices->getCollection()->transform(function ($invoice) {
            $totalPaid         = $invoice->receipts->sum('receipt_total');
            $invoice->total_paid = $totalPaid;
            $invoice->balance    = $invoice->amount - $totalPaid;
            return $invoice;
        });

        return view('pages.invoice.index', compact('invoices'));
    }

    public function create()
    {
        $leases = Lease::with(['tenant', 'apartment'])->where('status', 'Active')->get();
        return view('pages.invoice.create', compact('leases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lease_id'     => 'required',
            'tenant_id'    => 'required',
            'amount'       => 'required|numeric',
            'period'       => 'required',
            'invoice_date' => 'required|date',
            'due_date'     => 'required|date',
        ]);

        $invoice = Invoice::create([
            'company_id'   => Auth::user()->company_id,
            'lease_id'     => $request->lease_id,
            'tenant_id'    => $request->tenant_id,
            'amount'       => $request->amount,
            'period'       => $request->period,
            'invoice_date' => $request->invoice_date,
            'due_date'     => $request->due_date,
            'late_fee'     => $request->late_fee ?? 0,
            'notes'        => $request->notes,
            'status'       => 'Pending',
            'created_by'   => Auth::id(),
        ]);

        // Auto-create invoice detail line
        InvoiceDetail::create([
            'company_id'  => Auth::user()->company_id,
            'invoice_id'  => $invoice->id,
            'description' => 'Monthly Rent — ' . $request->period,
            'price'       => $request->amount,
            'qty'         => 1,
            'vat'         => 0,
            'discount'    => 0,
            'sort_order'  => 1,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice generated successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['tenant', 'lease.apartment.building', 'details', 'receipts'])->findOrFail($id);
        return view('pages.invoice.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $leases  = Lease::with(['tenant', 'apartment'])->get();
        return view('pages.invoice.edit', compact('invoice', 'leases'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount'   => 'required|numeric',
            'due_date' => 'required|date',
            'status'   => 'required',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'amount'     => $request->amount,
            'due_date'   => $request->due_date,
            'status'     => $request->status,
            'notes'      => $request->notes,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function delete($id)
    {
        $invoice = Invoice::with(['tenant', 'lease.apartment'])->findOrFail($id);
        return view('pages.invoice.delete', compact('invoice'));
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->status === 'Paid') {
            return redirect()->back()->with('error', 'Cannot delete a paid invoice.');
        }

        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
