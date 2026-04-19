<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Ledger — {{ $tenant->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #fff;
            color: #16191f;
            padding: 40px;
            font-size: 13px;
        }

        /* ── PRINT BUTTON (screen only) ── */
        .no-print {
            text-align: center;
            margin-bottom: 28px;
        }

        .btn-print-now {
            padding: 10px 32px;
            background: #1a6b4a;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-print-now:hover { background: #155a3d; }

        /* ── HEADER ── */
        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 2px solid #1a6b4a;
        }

        .print-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a6b4a;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .print-brand span { color: #c49a2a; }

        .print-brand-sub {
            font-size: 11px;
            letter-spacing: 2px;
            color: #8c93a3;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .print-meta { text-align: right; }

        .print-meta h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 700;
            color: #16191f;
            margin-bottom: 6px;
        }

        .print-meta p { font-size: 12px; color: #4a5160; margin-bottom: 2px; }

        /* ── TENANT INFO ── */
        .tenant-info {
            background: #f7f8fa;
            border-left: 4px solid #1a6b4a;
            padding: 14px 18px;
            border-radius: 4px;
            margin-bottom: 24px;
            display: flex;
            gap: 48px;
        }

        .tenant-info-item span {
            display: block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #8c93a3;
            margin-bottom: 3px;
        }

        .tenant-info-item strong { font-size: 14px; color: #16191f; }

        /* ── TABLE ── */
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }

        thead tr { background: #1a6b4a; }

        thead th {
            padding: 10px 12px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #ffffff;
            text-align: left;
            white-space: nowrap;
        }

        thead th.right { text-align: right; }

        tbody tr { border-bottom: 1px solid #f0f1f4; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:last-child { border-bottom: 2px solid #e8eaef; }

        tbody td {
            padding: 9px 12px;
            font-size: 12.5px;
            color: #4a5160;
            vertical-align: middle;
        }

        tbody td.right  { text-align: right; }
        tbody td strong { color: #16191f; font-weight: 500; }

        .amount-pos { color: #c0392b; font-weight: 600; }
        .amount-neg { color: #1a6b4a; font-weight: 600; }

        .type-invoice { color: #a07820; font-weight: 500; }
        .type-payment { color: #1a6b4a; font-weight: 500; }

        /* ── SUMMARY ── */
        .print-summary {
            display: flex;
            justify-content: flex-end;
            gap: 48px;
            margin-bottom: 32px;
            padding: 16px 20px;
            background: #f7f8fa;
            border-radius: 6px;
            border: 1px solid #e8eaef;
        }

        .summary-item span {
            display: block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #8c93a3;
            margin-bottom: 4px;
        }

        .summary-item strong {
            font-size: 16px;
            font-family: 'Cormorant Garamond', serif;
        }

        .summary-item.due strong  { color: #c0392b; }
        .summary-item.paid strong { color: #1a6b4a; }
        .summary-item.bill strong { color: #16191f; }

        /* ── FOOTER ── */
        .print-footer {
            text-align: center;
            font-size: 11px;
            color: #8c93a3;
            padding-top: 20px;
            border-top: 1px solid #e8eaef;
        }

        @media print {
            .no-print { display: none !important; }
            body { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn-print-now" onclick="window.print()">
            🖨 Print / Save as PDF
        </button>
    </div>

    {{-- HEADER --}}
    <div class="print-header">
        <div>
            <div class="print-brand">Shams <span>Rental</span></div>
            <div class="print-brand-sub">Premium Property Management</div>
        </div>
        <div class="print-meta">
            <h2>Transaction Ledger</h2>
            <p><strong>Tenant:</strong> {{ $tenant->name }}</p>
            <p><strong>Printed:</strong> {{ now()->format('d M, Y — h:i A') }}</p>
        </div>
    </div>

    {{-- TENANT INFO --}}
    <div class="tenant-info">
        <div class="tenant-info-item">
            <span>Tenant Name</span>
            <strong>{{ $tenant->name }}</strong>
        </div>
        <div class="tenant-info-item">
            <span>Email</span>
            <strong>{{ $tenant->email ?? '—' }}</strong>
        </div>
        <div class="tenant-info-item">
            <span>Mobile</span>
            <strong>{{ $tenant->mobile ?? '—' }}</strong>
        </div>
        <div class="tenant-info-item">
            <span>Total Entries</span>
            <strong>{{ $transactions->count() }}</strong>
        </div>
    </div>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th>Sl.</th>
                <th>Date</th>
                <th>Transaction Type</th>
                <th class="right">Amount (৳)</th>
                <th>Ref.</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $i => $tx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($tx['date'])->format('d-m-Y') }}</td>
                <td class="{{ $tx['type'] == 'invoice' ? 'type-invoice' : 'type-payment' }}">
                    {{ $tx['label'] }}
                </td>
                <td class="right">
                    <span class="{{ $tx['amount'] > 0 ? 'amount-pos' : 'amount-neg' }}">
                        {{ $tx['amount'] > 0 ? '+' : '' }}{{ number_format($tx['amount'], 0) }}
                    </span>
                </td>
                <td><strong>{{ $tx['ref'] }}</strong></td>
                <td></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:24px; color:#8c93a3;">
                    No transactions found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- SUMMARY --}}
    @php
        $totalBilled  = $transactions->where('type', 'invoice')->sum('amount');
        $totalPaid    = abs($transactions->where('type', 'payment')->sum('amount'));
        $finalBalance = $totalBilled - $totalPaid;
    @endphp

    <div class="print-summary">
        <div class="summary-item bill">
            <span>Total Billed</span>
            <strong>৳ {{ number_format($totalBilled, 2) }}</strong>
        </div>
        <div class="summary-item paid">
            <span>Total Paid</span>
            <strong>৳ {{ number_format($totalPaid, 2) }}</strong>
        </div>
        <div class="summary-item due">
            <span>Outstanding Balance</span>
            <strong>৳ {{ number_format($finalBalance, 2) }}</strong>
        </div>
    </div>

    <div class="print-footer">
        System-generated statement &nbsp;·&nbsp; Shams Rental Management System
        &nbsp;·&nbsp; {{ now()->format('d M Y') }}
    </div>

</body>
</html>