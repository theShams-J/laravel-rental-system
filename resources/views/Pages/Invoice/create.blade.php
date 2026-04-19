@extends("layouts.master")
@section('page')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Invoice</h4>
    <a href="{{ route('invoices.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<x-card title="Generate New Invoice">
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="lease_id" class="form-label">Select Lease/Tenant</label>
                <select name="lease_id" id="lease_id" class="form-control" required>
    <option value="">-- Select Active Lease --</option>
    @foreach($leases as $lease)
        <option value="{{ $lease->id }}" data-tenant-id="{{ $lease->tenant_id }}">
            {{-- Use ?-> to safely handle missing apartment or tenant --}}
            {{ $lease->apartment?->apartment_no ?? 'No Unit' }} - 
            {{ $lease->tenant?->name ?? 'Unknown Tenant' }} 
            ({{ $lease->start_date }} to {{ $lease->end_date }})
        </option>
    @endforeach
</select>
                <input type="hidden" name="tenant_id" id="tenant_id">
            </div>

            <div class="col-md-6 mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-control" placeholder="0.00" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="period" class="form-label">Billing Period</label>
                <input type="text" name="period" id="period" class="form-control" placeholder="e.g. Jan 2026" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="invoice_date" class="form-label">Invoice Date</label>
                <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control" required>
            </div>
        </div>
        
        <input type="hidden" name="status" value="Unpaid">

        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Save Invoice
        </button>
    </form>
</x-card>

{{-- Simple Script to set tenant_id when lease is selected --}}
<script>
    document.getElementById('lease_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var tenantId = selectedOption.getAttribute('data-tenant-id');
        document.getElementById('tenant_id').value = tenantId;
    });
</script>
@endsection