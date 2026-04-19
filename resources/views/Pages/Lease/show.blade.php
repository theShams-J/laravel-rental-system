@extends("layouts.master")
@section("page")
<x-card title="Lease Details - ID: {{ $lease->id }}">
    <div class="row mb-3">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr><th>Tenant</th><td>{{ $lease->tenant->name }}</td></tr>
                <tr><th>Apartment</th><td>{{ $lease->apartment->apartment_no }}</td></tr>
                <tr><th>Start Date</th><td>{{ $lease->start_date }}</td></tr>
                <tr><th>End Date</th><td>{{ $lease->end_date }}</td></tr>
                <tr><th>Total Paid</th><td class="text-success fw-bold">${{ number_format($lease->total_paid, 2) }}</td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr><th>Monthly Rent</th><td>${{ number_format($lease->monthly_rent, 2) }}</td></tr>
                <tr><th>Security Deposit</th><td>${{ number_format($lease->security_deposit, 2) }}</td></tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge {{ $lease->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                            {{ $lease->status }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="d-flex gap-2">
        <a href="{{ route('leases.index') }}" class="btn btn-dark">Back to List</a>
        <a href="{{ route('leases.edit', $lease->id) }}" class="btn btn-primary">Edit Lease</a>
    </div>

    <hr>
    <h3>Invoices</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Period</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lease->invoices as $invoice)
            <tr>
                <td>{{ $invoice->period }}</td>
                <td>${{ number_format($invoice->amount, 2) }}</td>
                <td>{{ $invoice->due_date }}</td>
                <td>
                    <span class="badge {{ $invoice->status == 'Paid' ? 'bg-success' : 'bg-warning' }}">
                        {{ $invoice->status }}
                    </span>
                </td>
                <td>
                    @if($invoice->status != 'Paid')
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $invoice->id }}">
                            Record Payment
                        </button>
                    @endif
                </td>
            </tr>

            <div class="modal fade" id="paymentModal{{ $invoice->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Record Payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="/finance/record-payment/{{ $invoice->id }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Amount Paid</label>
                                    <input type="number" name="amount_paid" class="form-control" step="0.01" value="{{ $invoice->amount }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Payment Method</label>
                                    <select name="payment_method" class="form-control" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</x-card>
@endsection