@extends("layouts.tenant_layout")
@section("page")

<div style="padding: 28px 24px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Money Receipts</h4>
    </div>

    <div style="background:#fff; border-radius:10px; border:1px solid #e8eaef; overflow:hidden;">
        <table class="td-table" style="width:100%;">
            <thead>
                <tr>
                    <th>MR #</th>
                    <th>Date</th>
                    <th style="text-align:right;">Amount</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipts as $receipt)
                <tr>
                    <td><strong>MR #{{ $receipt->id }}</strong></td>
                    <td>{{ $receipt->created_at->format('d M, Y') }}</td>
                    <td style="text-align:right;">৳ {{ number_format($receipt->receipt_total, 2) }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('tenant.receipt.show', $receipt->id) }}" class="btn-print">
                            <span class="fas fa-eye"></span> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:36px; color:#8c93a3;">No receipts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection