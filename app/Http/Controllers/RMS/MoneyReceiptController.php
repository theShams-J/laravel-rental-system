<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RMS\MoneyReceipt;
use App\Models\RMS\MoneyReceiptDetail;
use App\Models\RMS\Invoice;
use App\Models\RMS\Lease;
use App\Models\RMS\User;
use App\Models\RMS\Notification;

class MoneyReceiptController extends Controller
{
    public function index()
    {
        $receipts = MoneyReceipt::with(['tenant', 'invoice'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.receipt.index', compact('receipts'));
    }

    public function create(Request $request)
    {
        $invoices = Invoice::where('status', '!=', 'Paid')
            ->with(['tenant', 'receipts'])
            ->get()
            ->map(function ($invoice) {
                $totalPaid             = $invoice->receipts->sum('receipt_total');
                $invoice->balance_due  = $invoice->amount - $totalPaid;
                return $invoice;
            });

        $selectedInvoice = null;
        if ($request->has('invoice_id')) {
            $selectedInvoice = $invoices->where('id', $request->invoice_id)->first();
        }

        return view('pages.receipt.create', compact('invoices', 'selectedInvoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id'    => 'required|exists:rms_invoices,id',
            'tenant_id'     => 'required|exists:rms_tenants,id',
            'lease_id'      => 'required|exists:rms_leases,id',
            'receipt_total' => 'required|numeric|min:0.01',
            'payment_method'=> 'required|string',
        ]);

        $amountPaid = $request->receipt_total;

        DB::transaction(function () use ($request, $amountPaid) {
            $invoice    = Invoice::findOrFail($request->invoice_id);
            // $amountPaid = $request->receipt_total; // Already defined outside

            // Create receipt header
            $receipt = MoneyReceipt::create([
                'company_id'     => Auth::user()->company_id,
                'invoice_id'     => $request->invoice_id,
                'tenant_id'      => $request->tenant_id,
                'lease_id'       => $request->lease_id,
                'payment_method' => $request->payment_method,
                'transaction_no' => $request->transaction_no,
                'reference_no'   => $request->reference_no,
                'remark'         => $request->remark,
                'receipt_total'  => $amountPaid,
                'discount'       => $request->discount ?? 0,
                'vat'            => $request->vat ?? 0,
                'received_by'    => Auth::id(),
                'created_by'     => Auth::id(),
            ]);

            // Create receipt detail line
            MoneyReceiptDetail::create([
                'company_id'       => Auth::user()->company_id,
                'money_receipt_id' => $receipt->id,
                'description'      => 'Payment for Invoice #' . $request->invoice_id,
                'price'            => $amountPaid,
                'qty'              => 1,
                'vat'              => 0,
                'discount'         => 0,
                'sort_order'       => 1,
            ]);

            // Update invoice status
            $totalPaidSoFar = MoneyReceipt::where('invoice_id', $invoice->id)->sum('receipt_total');

            if ($totalPaidSoFar >= $invoice->amount) {
                $invoice->update(['status' => 'Paid', 'paid_at' => now(), 'updated_by' => Auth::id()]);
            } else {
                $invoice->update(['status' => 'Pending', 'updated_by' => Auth::id()]);
            }

            // Update lease total_paid
            Lease::where('id', $request->lease_id)->increment('total_paid', $amountPaid);
        });

        // Notify admins about payment receipt
        $admins = User::where('company_id', Auth::user()->company_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->get();

        foreach ($admins as $admin) {
            Notification::create([
                'company_id' => Auth::user()->company_id,
                'user_id' => $admin->id,
                'type' => 'payment_receipt',
                'message' => "Payment received: ৳{$amountPaid} for Invoice #{$request->invoice_id}",
                'url' => route('receipts.index'), // or a show route if exists
            ]);
        }

        return redirect()->route('receipts.index')->with('success', 'Receipt generated successfully.');
    }

    public function show($id)
    {
        $receipt = MoneyReceipt::with(['details', 'tenant', 'invoice', 'lease.apartment.building'])->findOrFail($id);
        return view('pages.receipt.show', compact('receipt'));
    }

    public function update(Request $request, $id)
    {
        $receipt = MoneyReceipt::findOrFail($id);
        $receipt->update([
            'remark'     => $request->remark,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('receipts.index')->with('success', 'Receipt updated.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $receipt = MoneyReceipt::findOrFail($id);

            // Revert lease total_paid
            Lease::where('id', $receipt->lease_id)->decrement('total_paid', $receipt->receipt_total);

            // Revert invoice status
            Invoice::where('id', $receipt->invoice_id)->update(['status' => 'Pending']);

            $receipt->details()->delete();
            $receipt->delete();
        });

        return redirect()->route('receipts.index')->with('success', 'Receipt deleted and invoice reverted.');
    }
}
