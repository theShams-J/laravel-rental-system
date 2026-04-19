@extends("layouts.tenant_layout")

@section("page")
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-header bg-light d-flex justify-content-between align-items-center d-print-none">
        <h5 class="mb-0">Money Receipt Voucher</h5>
        <div>
            <a href="{{ route('tenant.receipts') }}" class="btn btn-falcon-default btn-sm me-2">Back</a>
            <button class="btn btn-falcon-primary btn-sm" onclick="window.print()">
                <span class="fas fa-print me-1"></span>Print Receipt
            </button>
        </div>
    </div>

    <div class="card-body p-5" id="printableArea">
        <div class="row justify-content-between align-items-start">
            <div class="col">
                <img src="{{ $authCompany->logo ? asset('storage/' . $authCompany->logo) : asset('assets/img/icons/spot-illustrations/d.png') }}" alt="Logo" width="150" class="mb-3">
                <h4 class="mb-1 text-dark">{{ $authCompany->name ?? 'SHAMS RENTAL' }}</h4>
                <p class="fs--1 text-600">Road RA, Dhaka, Bangladesh<br>Phone: +880 1XXX-XXXXXX</p>
            </div>
            <div class="col-auto text-end pt-5">
                <h2 class="text-uppercase text-700">Receipt</h2>
                <p class="mb-0 fw-bold">#MR-{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="fs--1 text-600">Date: {{ $receipt->created_at->format('d M, Y') }}</p>
            </div>
        </div>

        <hr class="my-4">

        <div class="row mb-5">
            <div class="col-6">
                <h6 class="text-400 text-uppercase fs--2">Received From:</h6>
                <h5 class="mb-1">{{ $receipt->tenant?->name ?? 'N/A' }}</h5>
                <p class="fs--1 text-600">
                    Lease Reference: #{{ $receipt->lease_id }}<br>
                    Payment Method: <strong>{{ $receipt->payment_method }}</strong>
                </p>
            </div>
            <div class="col-6 text-end">
                <h6 class="text-400 text-uppercase fs--2">Invoice Reference:</h6>
                <h5>INV-#{{ $receipt->invoice_id }}</h5>
                <p class="fs--1 text-600">Ref: {{ $receipt->transaction_no ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped border-bottom">
                <thead class="bg-200 text-900">
                    <tr>
                        <th class="border-0">Description</th>
                        <th class="border-0 text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($receipt->details as $detail)
                    <tr>
                        <td class="align-middle border-0">
                            <h6 class="mb-0 text-nowrap">{{ $detail->description }}</h6>
                        </td>
                        <td class="align-middle text-end border-0">{{ number_format($detail->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <table class="table table-sm table-borderless fs--1 text-end">
                    <tr>
                        <th class="text-900">Invoice Total:</th>
                        <td class="fw-semi-bold text-900">${{ number_format($receipt->invoice->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th class="text-success">Amount Paid Today:</th>
                        <td class="fw-bold text-success">(${{ number_format($receipt->receipt_total, 2) }})</td>
                    </tr>
                    <tr class="border-top border-200">
                        <th class="text-900 fs-0">Remaining Balance:</th>
                        <td class="fw-bold text-danger fs-0">
                            ${{ number_format($receipt->invoice->amount - $receipt->invoice->receipts->sum('receipt_total'), 2) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-6 pt-4">
            <div class="col-6 text-center">
                <div class="border-top border-300 w-75 mx-auto pt-2 fs--1">Customer Signature</div>
            </div>
            <div class="col-6 text-center">
                <div class="border-top border-300 w-75 mx-auto pt-2 fs--1">Authorized Signature</div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* 1. Hide Sidebar, Header, Footer, and Tenant Layout chrome */
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

        /* 2. Reset layout to full width */
        .main, .container, .container-fluid, .content {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            display: block !important;
            left: 0 !important;
        }

        /* 3. Hide action buttons and navigation */
        .btn, .breadcrumb, .page-header, .navbar-toggler {
            display: none !important;
        }

        /* 4. Format the receipt card */
        .card {
            visibility: visible !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        /* 5. Force white background, preserve text colors */
        body {
            background-color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        h1, h4, h5, div, td, th {
            color: #000 !important;
        }
    }
</style>
@endsection