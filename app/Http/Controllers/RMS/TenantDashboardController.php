<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RMS\Lease;
use App\Models\RMS\Invoice;
use App\Models\RMS\MoneyReceipt;
use App\Models\RMS\Tenant;

class TenantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $tenantId = session('tenant_id') ?? $request->query('tenant_id');

        if (!$tenantId) {
            return redirect('/')->withErrors(['email' => 'Please login to access the dashboard.']);
        }

        $tenant = Tenant::withoutGlobalScopes()->find($tenantId);

        if (!$tenant) {
            return redirect('/')->withErrors(['email' => 'Tenant profile not found.']);
        }

        $lease = Lease::withoutGlobalScopes()
            ->with('apartment.building')
            ->where('tenant_id', $tenantId)
            ->where('status', 'Active')
            ->first();

        $invoices = Invoice::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'desc')
            ->get();

        $receipts = MoneyReceipt::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalInvoiced = $invoices->sum('amount');
        $totalPaid     = $receipts->sum('receipt_total');
        $dueAmount     = $totalInvoiced - $totalPaid;

        $transactions   = collect();
        $runningBalance = 0;

        foreach ($invoices as $inv) {
            $transactions->push([
                'date'    => $inv->created_at,
                'type'    => 'invoice',
                'label'   => 'Invoice / Bill',
                'amount'  => +$inv->amount,
                'ref'     => 'Invoice #' . $inv->id,
                'remarks' => $inv->period ?? '—',
            ]);
        }

        foreach ($receipts as $rec) {
            $transactions->push([
                'date'    => $rec->created_at,
                'type'    => 'payment',
                'label'   => 'Money Receipt / Payment',
                'amount'  => -$rec->receipt_total,
                'ref'     => 'MR #' . $rec->id,
                'remarks' => $rec->remark ?? '—',
            ]);
        }

        $transactions = $transactions->sortBy('date')->values();
        $transactions = $transactions->map(function ($row) use (&$runningBalance) {
            $runningBalance  += $row['amount'];
            $row['balance']   = $runningBalance;
            return $row;
        })->reverse()->values();

        return view('pages.tenant.dashboard', compact(
            'tenant', 'lease', 'invoices', 'receipts', 'dueAmount', 'transactions'
        ));
    }

    // ─── Invoice List ────────────────────────────────────────────────────────────

    public function invoices()
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) return redirect('/');

        $invoices = Invoice::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.tenant.invoices', compact('invoices'));
    }

    // ─── Invoice Detail ──────────────────────────────────────────────────────────

    public function showInvoice($id)
    {
        $invoice = Invoice::withoutGlobalScopes()
            ->with(['lease.apartment.building', 'tenant', 'receipts'])
            ->findOrFail($id);

        return view('pages.tenant.invoice_show', compact('invoice'));
    }

    // ─── Receipt List ────────────────────────────────────────────────────────────

    public function receipts()
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) return redirect('/');

        $receipts = MoneyReceipt::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.tenant.receipts', compact('receipts'));
    }

    // ─── Receipt Detail ──────────────────────────────────────────────────────────

    public function showReceipt($id)
    {
        $receipt = MoneyReceipt::withoutGlobalScopes()
            ->with(['tenant', 'details', 'invoice.receipts', 'lease.apartment.building'])
            ->findOrFail($id);

        return view('pages.tenant.receipt_show', compact('receipt'));
    }

    // ─── Transaction Ledger ──────────────────────────────────────────────────────

    public function ledger()
    {
        $tenantId = session('tenant_id');
        if (!$tenantId) return redirect('/');

        $tenant   = Tenant::withoutGlobalScopes()->findOrFail($tenantId);
        $invoices = Invoice::withoutGlobalScopes()->where('tenant_id', $tenantId)->orderBy('created_at')->get();
        $receipts = MoneyReceipt::withoutGlobalScopes()->where('tenant_id', $tenantId)->orderBy('created_at')->get();

        $transactions   = collect();
        $runningBalance = 0;

        foreach ($invoices as $inv) {
            $transactions->push([
                'date'    => $inv->created_at,
                'type'    => 'invoice',
                'label'   => 'Invoice / Bill',
                'amount'  => +$inv->amount,
                'ref'     => 'Invoice #' . $inv->id,
                'remarks' => $inv->period ?? '—',
            ]);
        }

        foreach ($receipts as $rec) {
            $transactions->push([
                'date'    => $rec->created_at,
                'type'    => 'payment',
                'label'   => 'Money Receipt / Payment',
                'amount'  => -$rec->receipt_total,
                'ref'     => 'MR #' . $rec->id,
                'remarks' => $rec->remark ?? '—',
            ]);
        }

        $transactions = $transactions->sortBy('date')->values()->map(function ($row) use (&$runningBalance) {
            $runningBalance += $row['amount'];
            $row['balance']  = $runningBalance;
            return $row;
        })->reverse()->values();

        return view('pages.tenant.ledger', compact('tenant', 'transactions'));
    }

    // ─── Print Views ─────────────────────────────────────────────────────────────

    public function printInvoice($id)
    {
        $invoice = Invoice::withoutGlobalScopes()
            ->with(['lease.apartment.building', 'tenant'])
            ->findOrFail($id);

        return view('pages.tenant.print_invoice', compact('invoice'));
    }

    public function printReceipt($id)
    {
        $receipt = MoneyReceipt::withoutGlobalScopes()
            ->with(['tenant', 'details', 'invoice.receipts', 'lease.apartment'])
            ->findOrFail($id);

        return view('pages.tenant.print_receipt', compact('receipt'));
    }

    public function printTransactions($tenantId)
    {
        $tenant   = Tenant::withoutGlobalScopes()->findOrFail($tenantId);
        $invoices = Invoice::withoutGlobalScopes()->where('tenant_id', $tenantId)->orderBy('created_at')->get();
        $receipts = MoneyReceipt::withoutGlobalScopes()->where('tenant_id', $tenantId)->orderBy('created_at')->get();

        $transactions   = collect();
        $runningBalance = 0;

        foreach ($invoices as $inv) {
            $transactions->push([
                'date'    => $inv->created_at,
                'type'    => 'invoice',
                'label'   => 'Invoice / Bill',
                'amount'  => +$inv->amount,
                'ref'     => 'Invoice #' . $inv->id,
                'remarks' => $inv->period ?? '—',
            ]);
        }

        foreach ($receipts as $rec) {
            $transactions->push([
                'date'    => $rec->created_at,
                'type'    => 'payment',
                'label'   => 'Money Receipt / Payment',
                'amount'  => -$rec->receipt_total,
                'ref'     => 'MR #' . $rec->id,
                'remarks' => $rec->remark ?? '—',
            ]);
        }

        $transactions = $transactions->sortBy('date')->values()->map(function ($row) use (&$runningBalance) {
            $runningBalance += $row['amount'];
            $row['balance']  = $runningBalance;
            return $row;
        });

        return view('pages.tenant.print_transactions', compact('tenant', 'transactions'));
    }
}