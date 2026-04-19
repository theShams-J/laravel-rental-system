@extends("layouts.master")
@section('page')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a class='btn btn-secondary' href="{{ route('invoices.index') }}">Back to List</a>
    <div>
        <button onclick="window.print()" class="btn btn-dark">
            <i class="fa fa-print"></i> Print Invoice
        </button>
        {{-- Link to record payment with Invoice ID passed as a parameter --}}
@if($invoice->status != 'Paid')
    <a href="{{ route('receipts.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success">
        <i class="fa fa-money-bill"></i> Record Payment
    </a>
@endif
    </div>
</div>

<div class="card p-4 shadow-sm" style="max-width: 100%; margin: auto; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <div class="row mb-4">
        <div class="col-sm-6">
            <img src="{{ $authCompany->logo ? asset('storage/' . $authCompany->logo) : asset('assets/img/icons/spot-illustrations/d.png') }}" alt="Logo" width="100" class="mb-3">
            <h4 class="mb-1 text-dark">{{ $authCompany->name ?? 'SHAMS RENTAL' }}</h4>
            <p class="fs--1 text-600">Road RA,Dhaka, Bangladesh<br>Phone: +880 1XXX-XXXXXX</p>
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
        <th class="text-right">Invoice Grand Total</th>
        <th class="text-right">${{ number_format($invoice->amount, 2) }}</th>
    </tr>
    @if($invoice->receipts->count() > 0)
        <tr class="text-success">
            <th class="text-right">Total Payments Received</th>
            <th class="text-right">- ${{ number_format($invoice->receipts->sum('receipt_total'), 2) }}</th>
        </tr>
        <tr class="bg-light text-danger">
            <th class="text-right">Total Balance Due</th>
            <th class="text-right" style="font-size: 1.2rem;">
                ${{ number_format($invoice->amount - $invoice->receipts->sum('receipt_total'), 2) }}
            </th>
        </tr>
    @endif
</tfoot>
    </table>

    <div class="mt-5 text-center text-muted">
        <p>Thank you for your business!</p>
        <p><small>Payment via bank transfer or check payable to Your Company Name.</small></p>
    </div>
</div>

{{-- Add some basic print styles --}}
<style>
    @media print {
        /* 1. Hide the Sidebar, Header, Footer, and Customizer elements */
        .navbar-vertical, 
        .navbar-glass, 
        .footer, 
        .right-sidebar, 
        .settings-panel, 
        .setting-toggle,
        .offcanvas,
        #settings-offcanvas,
        .btn-close-falcon-container,
        header, 
        footer {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* 2. Reset the layout to take full width */
        .main, .container, .container-fluid, .content {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            display: block !important;
            left: 0 !important;
        }

        /* 3. Hide all Action Buttons and Navigation Breadcrumbs */
        .btn, .breadcrumb, .page-header, .navbar-toggler {
            display: none !important;
        }

        /* 4. Format the Invoice Card */
        .card {
            visibility: visible !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        /* 5. Force background to white and show text colors */
        body {
            background-color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Ensure standard black text for readability */
        h1, h4, h5, div, td, th {
            color: #000 !important;
        }
    }
</style>

@endsection