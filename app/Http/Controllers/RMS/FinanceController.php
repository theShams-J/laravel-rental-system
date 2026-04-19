<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RMS\Invoice;
use App\Models\RMS\Lease;

class FinanceController extends Controller
{
    public function recordPayment(Request $request, $invoiceId)
    {
        $request->validate([
            'amount_paid'    => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'reference_no'   => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);

        DB::beginTransaction();

        try {
            // Update invoice status
            if ($request->amount_paid >= $invoice->amount) {
                $invoice->update([
                    'status'     => 'Paid',
                    'paid_at'    => now(),
                    'updated_by' => Auth::id(),
                ]);
            }

            // Update lease total_paid
            Lease::where('id', $invoice->lease_id)
                ->increment('total_paid', $request->amount_paid);

            DB::commit();

            return redirect()->back()->with('success', 'Payment recorded successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
