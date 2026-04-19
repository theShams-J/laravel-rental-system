@extends("layouts.tenant_layout")
@section("page")

<div style="padding: 28px 24px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">My Invoices</h4>
    </div>

    <div style="background:#fff; border-radius:10px; border:1px solid #e8eaef; overflow:hidden;">
        <table class="td-table" style="width:100%;">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Period</th>
                    <th style="text-align:right;">Amount</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:right;">Action</th>
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
                        <a href="{{ route('tenant.invoice.show', $invoice->id) }}" class="btn-print">
                            <span class="fas fa-eye"></span> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:36px; color:#8c93a3;">No invoices found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection