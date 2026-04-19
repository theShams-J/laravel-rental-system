@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Money Receipts</h4>
    <a class='btn btn-primary btn-sm' href="{{ route('receipts.create') }}">
        <span class="fas fa-plus me-1"></span> Create New Receipt
    </a>
</div>

<x-card title="Money Receipts">
    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Date</th>
                <th>Tenant</th>
                <th>Invoice #</th>
                <th>Method</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipts as $receipt)
            <tr>
                <td>{{ $receipt->id }}</td>
                <td>{{ \Carbon\Carbon::parse($receipt->created_at)->format('d-m-Y') }}</td>
                {{-- Using ?-> to prevent "property of null" errors if tenant is missing --}}
                <td>{{ $receipt->tenant?->name ?? 'N/A' }}</td>
                <td>INV-{{ $receipt->invoice_id }}</td>
                <td>
                    <span class="badge bg-soft-info text-info">{{ $receipt->payment_method }}</span>
                </td>
                <td>{{ number_format($receipt->receipt_total, 2) }}</td>
                <td>
                    <x-action 
                        view="receipts/{{ $receipt->id }}" 
                        
                        delete="receipts/{{ $receipt->id }}"
                    ></x-action>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">      
                    {{ $receipts->links('pagination::bootstrap-5') }}     
                </td>
            </tr>
        </tfoot>
    </table>
</x-card>
@endsection