@extends("layouts.master")

@section("page")

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Super Admin Profile: {{ $superadmin->name }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('super.superadmins.edit', $superadmin->id) }}" class="btn btn-falcon-default btn-sm">
            <span class="fas fa-pencil-alt me-1"></span> Edit
        </a>
        <a href="{{ route('super.superadmins.index') }}" class="btn btn-falcon-primary btn-sm">
            <span class="fas fa-list me-1"></span> Back to List
        </a>
    </div>
</div>

<div class="row justify-content-center">

    <x-card title="{{ $superadmin->name }}" class="mb-3 text-center py-4">
        <div class="avatar avatar-5xl mb-3 shadow-sm rounded-circle mx-auto overflow-hidden" style="width: 120px; height: 120px;">
            @if($superadmin->photo)
                <img src="{{ asset('storage/' . $superadmin->photo) }}" alt="{{ $superadmin->name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;" />
            @else
                <div class="avatar-name bg-soft-danger text-danger fs-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 120px; height: 120px;">
                    <span>{{ strtoupper(substr($superadmin->name, 0, 1)) }}</span>
                </div>
            @endif
        </div>
        <h3 class="mb-1 fw-bold text-900">{{ $superadmin->name }}</h3>
        <p class="text-600">{{ $superadmin->email }}</p>
        @if($superadmin->contact)
            <p class="text-500 fs--1">{{ $superadmin->contact }}</p>
        @endif
        <span class="badge rounded-pill {{ $superadmin->is_active ? 'badge-soft-success' : 'badge-soft-danger' }} px-3 py-2">
            {{ $superadmin->is_active ? 'ACTIVE' : 'SUSPENDED' }}
        </span>
    </x-card>

    <x-card title="Account Information">
        <div class="row">

            <div class="col-sm-6 mb-3">
                <label class="text-500 fs--1 fw-bold text-uppercase">Role</label>
                <p class="text-900 mb-0 fw-semi-bold">
                    <span class="badge badge-soft-danger px-3 py-2">Super Admin</span>
                </p>
            </div>

            <div class="col-sm-6 mb-3">
                <label class="text-500 fs--1 fw-bold text-uppercase">Last Login</label>
                <p class="text-900 mb-0">
                    {{ $superadmin->last_login_at ? $superadmin->last_login_at->format('M d, Y h:i A') : 'Never' }}
                </p>
            </div>

            <div class="col-sm-6 mb-3">
                <label class="text-500 fs--1 fw-bold text-uppercase">Account Created</label>
                <p class="text-900 mb-0">
                    {{ $superadmin->created_at->format('M d, Y') }} at {{ $superadmin->created_at->format('h:i A') }}
                </p>
            </div>

            <div class="col-sm-6 mb-3">
                <label class="text-500 fs--1 fw-bold text-uppercase">Company Scope</label>
                <p class="text-900 mb-0">
                    <span class="badge badge-soft-warning">Global — All Companies</span>
                </p>
            </div>

            <div class="col-sm-12 mt-2">
                <div class="d-flex align-items-center p-3 border rounded bg-soft-danger mt-1">
                    <div class="icon-item bg-soft-danger text-danger me-3">
                        <span class="fas fa-user-shield"></span>
                    </div>
                    <div>
                        <h6 class="mb-0">System-Level Access</h6>
                        <p class="mb-0 fs--1 text-600">
                            This account has unrestricted access to all companies, data, and settings.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </x-card>

</div>

@endsection