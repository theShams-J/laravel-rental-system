@extends("layouts.master")

@section("page")
<div class="mb-3 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Create New Super Admin</h4>
    <a href="{{ route('super.superadmins.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row justify-content-center">
    <form action="{{ route('super.superadmins.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <x-card title="Super Admin Identity & Access">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="e.g. System Administrator"
                           value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="admin@system.com"
                           value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Contact Number</label>
                    <input type="text" name="contact"
                           class="form-control @error('contact') is-invalid @enderror"
                           placeholder="e.g. 01711000000"
                           value="{{ old('contact') }}">
                    @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Profile Photo</label>
                    <input type="file" name="photo"
                           class="form-control @error('photo') is-invalid @enderror"
                           accept="image/*">
                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Optional. Upload a profile picture for the super admin.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Role</label>
                    <input type="text" class="form-control bg-light" value="Super Admin" disabled>
                    <small class="text-muted">Super admins are always assigned the highest role.</small>
                </div>

                <div class="col-12"><hr class="my-1"></div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

            </div>

            <div class="mt-4 border-top pt-3">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i> Save Super Admin
                </button>
            </div>
        </x-card>

    </form>
</div>
@endsection