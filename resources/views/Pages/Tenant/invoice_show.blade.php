@extends("layouts.tenant_layout")
@section('page')

<div style="padding: 28px 24px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('tenant.invoices') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Invoices
        </a>
        <a href="{{ route('tenant.invoice.print', $invoice->id) }}" target="_blank" class="btn btn-dark btn-sm">
            <i class="fa fa-print"></i> Print Invoice
        </a>
    </div>

    {{-- Paste your existing invoice show card content here --}}
    <div class="card p-4 shadow-sm">
        <div class="row mb-4">
            <div class="col-sm-6">
                <img src="{{ $authCompany->logo ? asset('storage/' . $authCompany->logo) : asset('assets/img/icons/spot-illustrations/d.png') }}" alt="Logo" width="150" class="mb-3">
                <h4 class="mb-1 text-dark">{{ $authCompany->name ?? 'SHAMS RENTAL' }}</h4>
                <p class="fs--1 text-600">Road RA, Dhaka, Bangladesh<br>Phone: +880 1XXX-XXXXXX</p>
            </div>
            <div class="col-sm-6 text-end pt-5">
                <h1 class="text-uppercase" style="color: #4e73df;">Invoice</h1>
                <div><strong>Invoice #:</strong> {{ $invoice->id }}</div>
                <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}</div>
                <div><strong>Due Date:</strong> <span class="text-danger"><strong>{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</strong></span></div>
            </div>
        </div>

        <hr>

        <div class="row mb-4">
            <div class="col-sm-6">
                <h5 class="text-muted">Bill To:</h5>
                <h4 class="text-dark">{{ $invoice->tenant->name }}</h4>
                <div>Apartment: {{ $invoice->lease->apartment->apartment_no }}</div>
                <div>Phone: {{ $invoice->tenant->contact ?? 'N/A' }}</div>
                <div>Email: {{ $invoice->tenant->email ?? 'N/A' }}</div>
            </div>
            <div class="col-sm-6 text-end">
                <div class="mt-4">
                    <span class="badge {{ $invoice->status == 'Paid' ? 'badge-soft-success' : 'badge-soft-warning' }}" style="font-size:1.2rem; padding:10px;">
                        {{ strtoupper($invoice->status) }}
                    </span>
                </div>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Rent Payment</strong><br>
                        <small class="text-muted">Period: {{ $invoice->period }}</small>
                    </td>
                    <td class="text-end">৳ {{ number_format($invoice->amount, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-end">Grand Total</th>
                    <th class="text-end">৳ {{ number_format($invoice->amount, 2) }}</th>
                </tr>
                @if($invoice->receipts && $invoice->receipts->count() > 0)
                <tr class="text-success">
                    <th class="text-end">Total Payments Received</th>
                    <th class="text-end">- ৳ {{ number_format($invoice->receipts->sum('receipt_total'), 2) }}</th>
                </tr>
                <tr class="bg-light text-danger">
                    <th class="text-end">Balance Due</th>
                    <th class="text-end" style="font-size:1.2rem;">
                        ৳ {{ number_format($invoice->amount - $invoice->receipts->sum('receipt_total'), 2) }}
                    </th>
                </tr>
                @endif
            </tfoot>
        </table>

        <div class="mt-5 text-center text-muted">
            <p>Thank you for your business!</p>
        </div>
    </div>
</div>
@endsection