@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Admin Details: <span class="text-primary">{{ $admin->name }}</span></h4>
    <div>
        <a href="{{ route('super.admins.edit', $admin->id) }}" class="btn btn-warning btn-sm me-2">
            <span class="fas fa-edit me-1"></span> Edit Admin
        </a>
        <a href="{{ route('super.admins.index') }}" class="btn btn-falcon-default btn-sm">
            <span class="fas fa-list me-1"></span> Back to List
        </a>
    </div>
</div>

{{-- --- ALERT SECTION START --- --}}
@if(session('success'))
    <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">{{ session('success') }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
        <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1 fw-bold">{{ session('error') }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- --- ALERT SECTION END --- --}}

<div class="row">
    <!-- Profile Card -->
    <div class="col-lg-4 mb-3">
        <x-card title="Profile Information">
            <div class="text-center mb-3">
                @if($admin->photo)
                    <img src="{{ asset('storage/' . $admin->photo) }}" alt="{{ $admin->name }}"
                         class="rounded-circle border shadow-sm mb-3"
                         style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div class="avatar avatar-5xl mb-3 shadow-sm rounded-circle mx-auto">
                        <div class="avatar-name bg-soft-primary text-primary fs-2">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                    </div>
                @endif
                <h5 class="mb-1">{{ $admin->name }}</h5>
                <p class="text-muted mb-2">{{ $admin->email }}</p>
                <span class="badge {{ $admin->is_active ? 'badge-soft-success' : 'badge-soft-danger' }} fs--1">
                    {{ $admin->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <hr>

            <div class="row g-2">
                <div class="col-6">
                    <small class="text-muted d-block">Role</small>
                    <span class="badge badge-soft-info">{{ $admin->role->name ?? 'Admin' }}</span>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block">Company</small>
                    <span class="badge badge-soft-warning">{{ $admin->company->name ?? 'N/A' }}</span>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Details Card -->
    <div class="col-lg-8 mb-3">
        <x-card title="Account Details">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Full Name</label>
                    <p class="form-control-plaintext">{{ $admin->name }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email Address</label>
                    <p class="form-control-plaintext">{{ $admin->email }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Contact Number</label>
                    <p class="form-control-plaintext">{{ $admin->contact ?? 'Not provided' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Company</label>
                    <p class="form-control-plaintext">{{ $admin->company->name ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Account Status</label>
                    <p class="form-control-plaintext">
                        <span class="badge {{ $admin->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                            {{ $admin->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Last Login</label>
                    <p class="form-control-plaintext">
                        {{ $admin->last_login_at ? $admin->last_login_at->format('M d, Y H:i') : 'Never logged in' }}
                        @if($admin->last_login_at)
                            <br><small class="text-muted">{{ $admin->last_login_at->diffForHumans() }}</small>
                        @endif
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Account Created</label>
                    <p class="form-control-plaintext">
                        {{ $admin->created_at->format('M d, Y H:i') }}
                        <br><small class="text-muted">{{ $admin->created_at->diffForHumans() }}</small>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Last Updated</label>
                    <p class="form-control-plaintext">
                        {{ $admin->updated_at->format('M d, Y H:i') }}
                        <br><small class="text-muted">{{ $admin->updated_at->diffForHumans() }}</small>
                    </p>
                </div>
            </div>
        </x-card>
    </div>
</div>

<!-- Activity/Stats Cards -->
<div class="row">
    <div class="col-md-3 mb-3">
        <x-card>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-3xl me-3 bg-soft-primary">
                    <span class="fas fa-calendar-check text-primary fs-4"></span>
                </div>
                <div>
                    <h6 class="mb-0">Account Age</h6>
                    <p class="text-muted mb-0">{{ $admin->created_at->diffInDays() }} days</p>
                </div>
            </div>
        </x-card>
    </div>

    <div class="col-md-3 mb-3">
        <x-card>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-3xl me-3 bg-soft-success">
                    <span class="fas fa-user-check text-success fs-4"></span>
                </div>
                <div>
                    <h6 class="mb-0">Status</h6>
                    <p class="text-muted mb-0">{{ $admin->is_active ? 'Active' : 'Inactive' }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <div class="col-md-3 mb-3">
        <x-card>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-3xl me-3 bg-soft-info">
                    <span class="fas fa-building text-info fs-4"></span>
                </div>
                <div>
                    <h6 class="mb-0">Company</h6>
                    <p class="text-muted mb-0">{{ $admin->company->name ?? 'N/A' }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <div class="col-md-3 mb-3">
        <x-card>
            <div class="d-flex align-items-center">
                <div class="avatar avatar-3xl me-3 bg-soft-warning">
                    <span class="fas fa-clock text-warning fs-4"></span>
                </div>
                <div>
                    <h6 class="mb-0">Last Login</h6>
                    <p class="text-muted mb-0">
                        {{ $admin->last_login_at ? $admin->last_login_at->diffForHumans() : 'Never' }}
                    </p>
                </div>
            </div>
        </x-card>
    </div>
</div>

@endsection