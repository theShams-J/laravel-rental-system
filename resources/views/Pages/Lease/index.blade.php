@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Lease Management</h4>
    <a href="{{ route('leases.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Create New Lease
    </a>
</div>
{{-- Display Success Message --}}
@if(session('success'))
    <div class=\"alert alert-success\">
        {{ session('success') }}
    </div>
@endif
<x-card title="Lease Management">

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tenant</th>
                    <th>Apartment</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Rent</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leases as $lease)
                <tr>
                    <td>{{ $lease->id }}</td>
                    <td>
                        <a href="{{ route('tenants.show', $lease->tenant_id) }}">
                            {{ $lease->tenant->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('apartments.show', $lease->apartment_id) }}">
                            {{ $lease->apartment->apartment_no ?? 'N/A' }}
                        </a>
                    </td>
                    <td>{{ $lease->start_date }}</td>
                    <td>{{ $lease->end_date }}</td>
                    <td>${{ number_format($lease->monthly_rent, 2) }}</td>
                    <td>
                        <span class="badge 
                            {{ $lease->status == 'Active' ? 'bg-success' : '' }}
                            {{ $lease->status == 'Terminated' ? 'bg-warning' : '' }}
                            {{ $lease->status == 'Expired' ? 'bg-danger' : '' }}">
                            {{ $lease->status }}
                        </span>
                    </td>
                    <td>
                        {{-- Using your custom x-action component --}}
                        <x-action 
                        view="leases/{{ $lease->id }}"
                        edit="leases/{{ $lease->id }}" 
                        delete="leases/{{ $lease->id }}"
                    ></x-action>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No leases found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>
@endsection