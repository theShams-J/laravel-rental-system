@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Lease</h4>
    <a href="{{ route('leases.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<x-card title="Create New Lease">
  <form action="{{ route('leases.store') }}" method="POST">
    @csrf

    {{-- 1. Select Tenant (Pre-selects if coming from Tenant View) --}}
    <div class="mb-3">
        <label class="form-label">Tenant</label>
        <select name="tenant_id" class="form-control" required>
            <option value="">Select Tenant</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" 
                    {{ $selectedTenantId == $tenant->id ? 'selected' : '' }}>
                    {{ $tenant->name }} (NID: {{ $tenant->nid }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- 2. Select Apartment (Pre-selects if coming from Apartment View) --}}
    <div class="mb-3">
        <label class="form-label">Apartment</label>
        <select name="apartment_id" id="apartment_id" class="form-control" required>
            <option value="" data-rent="">Select Available Apartment</option>
            @foreach($apartments as $apartment)
                <option value="{{ $apartment->id }}" 
                        data-rent="{{ $apartment->rent }}" 
                        {{ $selectedApartmentId == $apartment->id ? 'selected' : '' }}>
                    {{ $apartment->apartment_no }} (Rent: {{ $apartment->rent }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- 3. Lease Details --}}
    <x-input name="start_date" label="Start Date" type="date" required />
    <x-input name="end_date" label="End Date" type="date" />
    
    {{-- Rent Input (Auto-filled by JS) --}}
    <div class="mb-3">
        <label class="form-label">Monthly Rent</label>
        <input type="number" name="monthly_rent" id="monthly_rent" class="form-control" step="0.01" required>
    </div>
    
    <x-input name="security_deposit" label="Security Deposit" type="number" step="0.01" />

    <button type="submit" class="btn btn-primary px-4">
        <i class="fas fa-save me-1"></i> Save Lease
    </button>
  </form>

 
</x-card>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const apartmentSelect = document.getElementById('apartment_id');
        const rentInput = document.getElementById('monthly_rent');

        function updateRent() {
            const selectedOption = apartmentSelect.options[apartmentSelect.selectedIndex];
            const rentValue = selectedOption.getAttribute('data-rent');
            rentInput.value = rentValue || '';
        }

        // Listen for changes
        apartmentSelect.addEventListener('change', updateRent);

        // Run immediately in case of pre-selection from URL
        if (apartmentSelect.value) {
            updateRent();
        }
    });
</script>
@endpush
@endsection