@extends("layouts.master")
@section('page')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Invoice Management</h4>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus me-1"></i> Create New Invoice
    </a>
</div>

<x-card title="Invoice List">
    
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tenant</th>
            <th>Total Amount</th>
            <th class="text-success">Paid</th>
            <th class="text-danger">Due Amount</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->tenant->name ?? 'N/A' }}</td>
            <td>${{ number_format($invoice->amount, 2) }}</td>
            <td class="text-success">${{ number_format($invoice->total_paid, 2) }}</td>
            <td class="text-danger fw-bold">${{ number_format($invoice->balance, 2) }}</td>
            <td>
                @if($invoice->balance <= 0)
                    <span class="badge badge-soft-success">Paid</span>
                @elseif($invoice->total_paid > 0)
                    <span class="badge badge-soft-info">Partial</span>
                @else
                    <span class="badge badge-soft-warning">Unpaid</span>
                @endif
            </td>
            <td>
                <x-action 
                    view="invoices/{{ $invoice->id }}" 
                 
                    delete="invoices/{{ $invoice->id }}/delete">
                </x-action>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</x-card>
@endsection