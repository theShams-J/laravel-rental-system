@extends("layouts.master")

@section("page")

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">User Profile: {{ $user->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-falcon-default btn-sm">
            <span class="fas fa-pencil-alt me-1"></span> Edit
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-falcon-primary btn-sm">
            <span class="fas fa-list me-1"></span> Back to List
        </a>
    </div>
</div>

<div class="row justify-content-center">

    {{-- Avatar Card --}}
    <x-card title="{{ $user->name }}" class="mb-3 text-center py-4">
        <div class="mb-3 mx-auto" style="width: 120px; height: 120px;">
            @if($user->photo)
                <img class="rounded-circle shadow-sm" src="{{ asset('storage/' . $user->photo) }}" alt="" style="width: 120px; height: 120px; object-fit: cover;" />
            @else
                <div class="avatar-name bg-soft-primary text-primary fs-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
            @endif
        </div>
        <h3 class="mb-1 fw-bold text-900">{{ $user->name }}</h3>
        <p class="text-600">{{ $user->email }}</p>
        @if($user->contact)
            <p class="text-500 fs--1">{{ $user->contact }}</p>
        @endif
        <span class="badge rounded-pill {{ $user->is_active ? 'badge-soft-success' : 'badge-soft-danger' }} px-3 py-2">
            {{ $user->is_active ? 'ACTIVE' : 'SUSPENDED' }}
        </span>
    </x-card>

    {{-- Account Info Card --}}
    <x-card title="Account Information">
        <div class="row">

            <div class="col-sm-6 mb-3">
                <label class="text-500 fs--1 fw-bold text-uppercase">Role</label>
                <p class="text-900 mb-0 fw-semi-bold">
                    {{ ucfirst(str_replace('_', ' ', $user->role->name ?? 'N/A')) }}
                </p>
            </div>

            <div class="col-sm-6 mb-3">
                <label class="text-500 fs--1 fw-bold text-uppercase">Account Created</label>
                <p class="text-900 mb-0">
                    {{ $user->created_at->format('M d, Y') }} at {{ $user->created_at->format('h:i A') }}
                </p>
            </div>

            <hr class="my-2 border-200">

            <div class="col-sm-12 mt-2">
                <label class="text-500 fs--1 fw-bold text-uppercase">Linked Profile</label>
                @if($user->tenant_id)
                    <div class="d-flex align-items-center p-3 border rounded bg-light mt-1">
                        <div class="icon-item bg-soft-primary text-primary me-3">
                            <span class="fas fa-user-tie"></span>
                        </div>
                        <div>
                            <h6 class="mb-0">
                                Tenant: <a href="{{ url('tenants/' . $user->tenant_id) }}">{{ $user->tenant->name }}</a>
                            </h6>
                            <p class="mb-0 fs--1 text-600">This user can log in to view rent history and invoices.</p>
                        </div>
                    </div>
                @else
                    <div class="d-flex align-items-center p-3 border rounded bg-soft-secondary mt-1">
                        <div class="icon-item bg-secondary text-white me-3">
                            <span class="fas fa-shield-alt"></span>
                        </div>
                        <div>
                            <h6 class="mb-0">Internal System Staff</h6>
                            <p class="mb-0 fs--1 text-600">This account is not linked to a tenant profile.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </x-card>

</div>

@endsection