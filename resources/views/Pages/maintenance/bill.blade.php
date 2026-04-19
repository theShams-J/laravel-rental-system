@extends('layouts.master')

@section('page')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Bill Maintenance to Tenant</h1>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Maintenance Summary -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Apartment</label>
                            <div>{{ $maintenance->apartment->name ?? 'N/A' }} ({{ $maintenance->apartment->building->name ?? 'N/A' }})</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <div>{{ $maintenance->title }}</div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Cost</label>
                            <div class="h5 mb-0 text-success">Rs. {{ number_format($maintenance->cost, 2) }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <div>
                                <span class="badge bg-success">{{ $maintenance->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing Form -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('maintenance.bill', $maintenance->id) }}">
                        @csrf

                        @php
                            $chargeMethod = old('charge_method', $pendingInvoice ? 'next_invoice' : 'separate_invoice');
                        @endphp

                        @if(!$pendingInvoice)
                            <div class="alert alert-warning">
                                No pending monthly invoice was found for this tenant. Select <strong>Create Separate Invoice</strong> or create a pending rent invoice first.
                            </div>
                        @endif

                        <!-- Charge Method -->
                        <div class="mb-4">
                            <label class="form-label" for="charge_method">Charge Method <span class="text-danger">*</span></label>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="charge_method" id="next_invoice" value="next_invoice" {{ $chargeMethod === 'next_invoice' ? 'checked' : '' }} @if(!$pendingInvoice) disabled @endif>
                                    <label class="form-check-label" for="next_invoice">
                                        <strong>Add to Next Monthly Rent</strong>
                                        <br><small class="text-muted">Add this maintenance cost to the tenant's next pending rent invoice.</small>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="charge_method" id="separate_invoice" value="separate_invoice" {{ $chargeMethod === 'separate_invoice' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="separate_invoice">
                                        <strong>Create Separate Invoice</strong>
                                        <br><small class="text-muted">Create a new invoice specifically for this maintenance charge.</small>
                                    </label>
                                </div>
                            </div>
                            @error('charge_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4" id="billingHelp">
                            <div class="alert alert-info mb-0" id="billingInfo">
                                The cost will be added as a line item to the tenant's next pending invoice.
                            </div>
                        </div>

                        <!-- Confirm Cost -->
                        <div class="mb-4">
                            <label class="form-label" for="cost">Cost <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" step="0.01" min="0" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost', $maintenance->cost) }}" required>
                            </div>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="form-footer mt-4">
                            <a href="{{ route('maintenance.show', $maintenance->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success ms-2">
                                <i class="fas fa-money-bill me-2"></i>Confirm Billing
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                const nextInvoiceRadio = document.getElementById('next_invoice');
                const separateInvoiceRadio = document.getElementById('separate_invoice');
                const billingInfo = document.getElementById('billingInfo');

                function updateBillingInfo() {
                    if (nextInvoiceRadio.checked) {
                        billingInfo.textContent = 'The cost will be added as a line item to the tenant\'s next pending invoice.';
                    } else {
                        billingInfo.textContent = 'A new invoice will be created for this tenant. Payment can be collected via Money Receipt.';
                    }
                }

                nextInvoiceRadio.addEventListener('change', updateBillingInfo);
                separateInvoiceRadio.addEventListener('change', updateBillingInfo);
                updateBillingInfo();
            </script>
        </div>
    </div>

</div>
@endsection
