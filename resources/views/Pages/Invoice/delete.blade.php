@extends("layouts.master")
@section('page')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a class='btn btn-secondary' href="{{ route('invoices.index') }}">Back to List</a>
    <div>
      <form  action="{{route('invoices.destroy',$invoice)}}" method="POST">
    @csrf
    @method("DELETE")
    <button type="submit" class="btn btn-danger">Delete</button>
    </form>
        {{-- Link to record payment if not paid --}}
        @if($invoice->status != 'Paid')
            <a href="#" class="btn btn-success">
                <i class="fa fa-money-bill"></i> Record Payment
            </a>
        @endif
    </div>
</div>

<div class="card p-4 shadow-sm" style="max-width: 100%; margin: auto; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <div class="row mb-4">
        <div class="col-sm-6">
            <h1 class="text-uppercase" style="color: #4e73df;">Invoice</h1>
            <div><strong>Invoice #:</strong> {{ $invoice->id }}</div>
            <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</div>
            <div><strong>Due Date:</strong> <span class="text-danger"><strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</strong></span></div>
        </div>
        <div class="col-sm-6 text-right">
            <h4 class="text-dark">Your Company Name</h4>
            <div>123 Rental St, Apartment City</div>
            <div>Email: info@yourcompany.com</div>
        </div>
    </div>

    <hr>

    <div class="row mb-4">
        <div class="col-sm-6">
            <h5 class="text-muted">Bill To:</h5>
            <h4 class="text-dark">{{ $invoice->tenant->name }}</h4>
            <div>Apartment: {{ $invoice->lease->apartment->apartment_no }}</div>
            <div>Phone: {{ $invoice->tenant->phone ?? 'N/A' }}</div>
            <div>Email: {{ $invoice->tenant->email ?? 'N/A' }}</div>
        </div>
        <div class="col-sm-6 text-right">
            <div class="mt-4">
                <span class="badge badge-pill {{ $invoice->status == 'Paid' ? 'badge-success' : 'badge-warning' }}" style="font-size: 1.2rem; padding: 10px;">
                    {{ strtoupper($invoice->status) }}
                </span>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Description</th>
                <th class="text-right" width="150">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Rent Payment</strong><br>
                    <small class="text-muted">Period: {{ $invoice->period }}</small>
                </td>
                <td class="text-right">${{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right">Total</th>
                <th class="text-right">${{ number_format($invoice->amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="mt-5 text-center text-muted">
        <p>Thank you for your business!</p>
        <p><small>Payment via bank transfer or check payable to Your Company Name.</small></p>
    </div>
</div>

{{-- Add some basic print styles --}}


@endsection