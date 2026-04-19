@extends(session()->has('tenant_id') && !Auth::check() ? 'layouts.tenant_layout' : 'layouts.master')

@section('page')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap');

    :root {
        --ink:          #16191f;
        --ink-soft:     #4a5160;
        --ink-muted:    #8c93a3;
        --surface:      #f7f8fa;
        --white:        #ffffff;
        --emerald:      #1a6b4a;
        --emerald-pale: #edf7f2;
        --gold:         #c49a2a;
        --gold-pale:    #fdf6e3;
        --rose:         #c0392b;
        --rose-pale:    #fdf0ee;
        --border:       #e8eaef;
        --shadow-sm:    0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --radius:       10px;
    }

    .td-wrap * { font-family: 'DM Sans', sans-serif; }

    .td-wrap {
        background: var(--surface);
        min-height: 100vh;
        padding: 28px 24px 48px;
        position: relative;
    }

    /* ── WATERMARK ── */
    .td-watermark {
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        z-index: 0;
        opacity: 0.06;
        pointer-events: none;
        text-align: center;
        width: 100%;
    }
    .td-watermark img { width: 420px; max-width: 60vw; display: block; margin: 0 auto; }
    .td-watermark-text {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem; font-weight: 700; color: #1a6b4a;
        letter-spacing: 6px; margin-top: 16px; text-transform: uppercase;
    }

    .td-header, .td-stats, .td-panels, .td-ledger, .td-empty { position: relative; z-index: 1; }

    /* ── HEADER ── */
    .td-header {
        display: flex; align-items: flex-end; justify-content: space-between;
        margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid var(--border);
        animation: fadeDown 0.5s ease both;
    }
    .td-header-left .td-label {
        font-size: 11px; font-weight: 600; letter-spacing: 2.5px;
        text-transform: uppercase; color: var(--emerald); margin-bottom: 6px;
    }
    .td-header-left h1 {
        font-family: 'Playfair Display', serif;
        font-size: 28px; font-weight: 700; color: var(--ink); margin: 0; line-height: 1.1;
    }
    .td-header-actions { display: flex; gap: 10px; align-items: center; }

    .btn-back, .btn-action {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 6px; font-size: 13px;
        font-weight: 500; text-decoration: none; transition: all 0.2s;
        box-shadow: var(--shadow-sm); cursor: pointer; border: 1.5px solid;
    }
    .btn-back { background: var(--white); border-color: var(--border); color: var(--ink-soft); }
    .btn-back:hover { border-color: var(--emerald); color: var(--emerald); background: var(--emerald-pale); }
    .btn-action { background: var(--emerald); border-color: var(--emerald); color: var(--white); }
    .btn-action:hover { background: #155a3d; border-color: #155a3d; color: var(--white); }

    /* ── EMPTY ── */
    .td-empty {
        background: rgba(255,255,255,0.85); backdrop-filter: blur(6px);
        border-radius: var(--radius); border: 1.5px dashed var(--border);
        padding: 72px 32px; text-align: center; animation: fadeUp 0.5s ease both;
    }
    .td-empty-icon { width: 72px; height: 72px; background: var(--gold-pale); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 28px; color: var(--gold); }
    .td-empty h4 { font-family: 'Playfair Display', serif; font-size: 22px; color: var(--ink); margin-bottom: 10px; }
    .td-empty p { color: var(--ink-muted); font-size: 14px; margin: 0; line-height: 1.7; }

    /* ── STAT CARDS ── */
    .td-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media (max-width: 640px) { .td-stats { grid-template-columns: 1fr; } }

    .stat-card {
        background: rgba(255,255,255,0.88); backdrop-filter: blur(8px);
        border-radius: var(--radius); padding: 22px 24px;
        box-shadow: var(--shadow-sm); border: 1px solid var(--border);
        position: relative; overflow: hidden; animation: fadeUp 0.5s ease both;
    }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px; }
    .stat-card.unit::before    { background: var(--emerald); }
    .stat-card.balance::before { background: var(--rose); }
    .stat-card .stat-label { font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 14px; }
    .stat-card .stat-row   { display: flex; flex-direction: column; gap: 6px; }
    .stat-card .stat-item  { display: flex; justify-content: space-between; font-size: 13.5px; color: var(--ink-soft); }
    .stat-card .stat-item strong { color: var(--ink); font-weight: 500; }
    .stat-card.balance .big-amount { font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: var(--rose); line-height: 1; margin-bottom: 6px; }
    .stat-card.balance .big-label { font-size: 12px; color: var(--ink-muted); letter-spacing: 0.5px; }
    .stat-card.balance .bg-icon { position: absolute; bottom: -10px; right: 12px; font-size: 72px; color: rgba(192,57,43,0.05); pointer-events: none; }

    /* ── PANELS ── */
    .td-panels { display: grid; grid-template-columns: 1.4fr 1fr; gap: 16px; margin-bottom: 20px; }
    @media (max-width: 900px) { .td-panels { grid-template-columns: 1fr; } }
    .td-ledger { margin-top: 4px; animation: fadeUp 0.7s ease both; }

    .td-panel {
        background: rgba(255,255,255,0.88); backdrop-filter: blur(8px);
        border-radius: var(--radius); border: 1px solid var(--border);
        box-shadow: var(--shadow-sm); overflow: hidden; animation: fadeUp 0.6s ease both;
    }
    .td-panel-head {
        padding: 16px 20px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: rgba(252,252,253,0.9);
    }
    .td-panel-head h6 { font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-soft); margin: 0; }
    .count-badge { font-size: 11px; font-weight: 600; background: var(--surface); border: 1px solid var(--border); color: var(--ink-muted); padding: 2px 9px; border-radius: 20px; }

    /* ── TABLE ── */
    .td-table { width: 100%; border-collapse: collapse; }
    .td-table thead tr { background: var(--surface); }
    .td-table thead th { padding: 10px 16px; font-size: 10.5px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--ink-muted); border-bottom: 1px solid var(--border); white-space: nowrap; }
    .td-table tbody tr { border-bottom: 1px solid #f0f1f4; transition: background 0.15s; }
    .td-table tbody tr:last-child { border-bottom: none; }
    .td-table tbody tr:hover { background: rgba(237,247,242,0.5); }
    .td-table tbody td { padding: 12px 16px; font-size: 13.5px; color: var(--ink-soft); vertical-align: middle; }
    .td-table tbody td strong { color: var(--ink); font-weight: 500; }

    .type-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
    .type-badge.invoice { background: var(--gold-pale); color: #a07820; }
    .type-badge.payment { background: var(--emerald-pale); color: var(--emerald); }
    .type-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; display: inline-block; }

    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
    .status-badge.paid   { background: var(--emerald-pale); color: var(--emerald); }
    .status-badge.unpaid { background: var(--gold-pale); color: #a07820; }
    .status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; display: inline-block; }

    .amount-positive { color: var(--rose); font-weight: 600; }
    .amount-negative { color: var(--emerald); font-weight: 600; }

    .btn-print {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 10px; font-size: 12px; font-weight: 500;
        color: var(--emerald); background: var(--emerald-pale);
        border: none; border-radius: 5px; text-decoration: none;
        transition: all 0.2s; cursor: pointer;
    }
    .btn-print:hover { background: var(--emerald); color: var(--white); }

    .td-table .empty-row td { text-align: center; padding: 36px; color: var(--ink-muted); font-size: 13px; }
    .stat-card:nth-child(2) { animation-delay: 0.08s; }
    .td-panel:nth-child(2)  { animation-delay: 0.12s; }

    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="td-wrap">

    {{-- WATERMARK --}}
    <div class="td-watermark">
        <img src="{{ asset('assets/img/icons/spot-illustrations/d.png') }}" alt="">
        <div class="td-watermark-text">Comfort · Elegance · Luxury</div>
    </div>

    {{-- HEADER --}}
    <div class="td-header">
        <div class="td-header-left">
            <div class="td-label">Tenant Portal</div>
            <h1>{{ $tenant->name }}</h1>
        </div>
        <div class="td-header-actions">
            <a href="{{ route('tenant.transactions.print', $tenant->id) }}"
               target="_blank" class="btn-action">
                <span class="fas fa-print"></span> Print Transactions
            </a>
            {{-- Show back button only when admin is viewing this tenant --}}
            @if(Auth::check() && Auth::user()->isSuperAdmin() || Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('tenants.index') }}" class="btn-back">
                    <span class="fas fa-arrow-left"></span> Back to List
                </a>
            @endif
        </div>
    </div>

    @if(!$lease)
        {{-- EMPTY STATE --}}
        <div class="td-empty">
            <div class="td-empty-icon"><span class="fas fa-home"></span></div>
            <h4>No Apartment Assigned</h4>
            <p>You are not currently linked to an active rental unit.<br>Please contact management for assistance.</p>
        </div>

    @else

        {{-- STAT CARDS --}}
        <div class="td-stats">

            {{-- Unit Info --}}
            <div class="stat-card unit">
                <div class="stat-label">Rented Unit</div>
                <div class="stat-row">
                    <div class="stat-item">
                        <span>Building</span>
                        <strong>{{ $lease->apartment->building->name ?? '—' }}</strong>
                    </div>
                    <div class="stat-item">
                        <span>Apartment</span>
                        <strong>{{ $lease->apartment->apartment_no ?? '—' }}</strong>
                    </div>
                    <div class="stat-item">
                        <span>Floor</span>
                        <strong>{{ $lease->apartment->floor ?? '—' }}</strong>
                    </div>
                    <div class="stat-item">
                        <span>Monthly Rent</span>
                        <strong>৳ {{ number_format($lease->monthly_rent, 0) }}</strong>
                    </div>
                    <div class="stat-item">
                        <span>Lease Started</span>
                        <strong>{{ \Carbon\Carbon::parse($lease->start_date)->format('d M, Y') }}</strong>
                    </div>
                    <div class="stat-item">
                        <span>Lease Ends</span>
                        <strong>{{ $lease->end_date ? \Carbon\Carbon::parse($lease->end_date)->format('d M, Y') : 'Open' }}</strong>
                    </div>
                </div>
            </div>

            {{-- Balance --}}
            <div class="stat-card balance">
                <div class="stat-label">Payment Summary</div>
                <div class="big-amount">৳ {{ number_format($dueAmount, 2) }}</div>
                <div class="big-label">Total outstanding balance</div>
                <div style="margin-top: 16px;">
                    <div class="stat-row">
                        <div class="stat-item">
                            <span>Total Billed</span>
                            <strong>৳ {{ number_format($invoices->sum('amount'), 0) }}</strong>
                        </div>
                        <div class="stat-item">
                            <span>Total Paid</span>
                            <strong style="color:var(--emerald);">৳ {{ number_format($receipts->sum('receipt_total'), 0) }}</strong>
                        </div>
                    </div>
                </div>
                <div class="bg-icon"><span class="fas fa-wallet"></span></div>
            </div>

        </div>

       {{-- INVOICES + PAYMENTS --}}
<div class="td-panels" id="invoices">

    {{-- Invoices --}}
    <div class="td-panel">
        <div class="td-panel-head">
            <h6>Recent Invoices</h6>
            <span class="count-badge">{{ $invoices->count() }} records</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="td-table">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Period</th>
                        <th style="text-align:right;">Amount</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td><strong>#{{ $invoice->id }}</strong></td>
                        <td>{{ $invoice->period ?? '—' }}</td>
                        <td style="text-align:right;">৳ {{ number_format($invoice->amount, 2) }}</td>
                        <td style="text-align:center;">
                            <span class="status-badge {{ strtolower($invoice->status) == 'paid' ? 'paid' : 'unpaid' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('tenant.invoice.show', $invoice->id) }}" class="btn-print me-1">
                                <span class="fas fa-eye"></span> View
                            </a>
                            <a href="{{ route('tenant.invoice.print', $invoice->id) }}" target="_blank" class="btn-print">
                                <span class="fas fa-print"></span> Print
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="5">No invoices found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Payment History --}}
    <div class="td-panel" id="payments">
        <div class="td-panel-head">
            <h6>Payment History</h6>
            <span class="count-badge">{{ $receipts->count() }} records</span>
        </div>
        <div style="overflow-x:auto;">
            <table class="td-table">
                <thead>
                    <tr>
                        <th>MR #</th>
                        <th>Date</th>
                        <th style="text-align:right;">Amount</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($receipts as $receipt)
                    <tr>
                        <td><strong>MR #{{ $receipt->id }}</strong></td>
                        <td>{{ $receipt->created_at->format('d M, Y') }}</td>
                        <td style="text-align:right;" class="amount-negative">
                            ৳ {{ number_format($receipt->receipt_total, 2) }}
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('tenant.receipt.show', $receipt->id) }}" class="btn-print me-1">
                                <span class="fas fa-eye"></span> View
                            </a>
                            <a href="{{ route('tenant.receipt.print', $receipt->id) }}" target="_blank" class="btn-print" target="_blank" class="btn-print">
                                <span class="fas fa-print"></span> Print
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="4">No payment records.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

        {{-- TRANSACTION LEDGER --}}
        <div class="td-ledger">
            <div class="td-panel">
                <div class="td-panel-head">
                    <h6><span class="fas fa-list-alt me-2"></span> Transaction Ledger</h6>
                    <span class="count-badge">{{ $transactions->count() }} entries</span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="td-table">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Date</th>
                                <th>Transaction Type</th>
                                <th style="text-align:right;">Amount (৳)</th>
                                <th>Ref.</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $i => $tx)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($tx['date'])->format('d-m-Y') }}</td>
                                <td>
                                    <span class="type-badge {{ $tx['type'] }}">
                                        {{ $tx['label'] }}
                                    </span>
                                </td>
                                <td style="text-align:right;">
                                    <span class="{{ $tx['amount'] > 0 ? 'amount-positive' : 'amount-negative' }}">
                                        {{ $tx['amount'] > 0 ? '+' : '' }}{{ number_format($tx['amount'], 0) }}
                                    </span>
                                </td>
                                <td><strong>{{ $tx['ref'] }}</strong></td>
                                <td>{{ $tx['remarks'] != '—' ? $tx['remarks'] : '' }}</td>
                            </tr>
                            @empty
                            <tr class="empty-row"><td colspan="6">No transactions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif
</div>

@endsection