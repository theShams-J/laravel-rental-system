@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Lease</h4>
    <a href="{{ route('leases.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Edit Lease - ID: {{ $lease->id }}">
  <form action="{{ route('leases.update', $lease->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Tenant Selection --}}
    <div class="mb-3">
        <label class="form-label">Tenant</label>
        <select name="tenant_id" class="form-control" required>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" {{ $lease->tenant_id == $tenant->id ? 'selected' : '' }}>
                    {{ $tenant->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Apartment Selection --}}
    <div class="mb-3">
        <label class="form-label">Apartment</label>
        <select name="apartment_id" class="form-control" required>
            @foreach($apartments as $apartment)
                <option value="{{ $apartment->id }}" {{ $lease->apartment_id == $apartment->id ? 'selected' : '' }}>
                    {{ $apartment->apartment_no }}
                </option>
            @endforeach
        </select>
    </div>

    <x-input name="start_date" label="Start Date" type="date" value="{{ $lease->start_date }}" required />
    <x-input name="end_date" label="End Date" type="date" value="{{ $lease->end_date }}" />
    <x-input name="monthly_rent" label="Monthly Rent" type="number" step="0.01" value="{{ $lease->monthly_rent }}" required />
    <x-input name="security_deposit" label="Security Deposit" type="number" step="0.01" value="{{ $lease->security_deposit }}" />

    <button type="submit" class="btn btn-primary px-4">
        <i class="fas fa-save me-1"></i> Save Lease
    </button>
  </form>
</x-card>
@endsection