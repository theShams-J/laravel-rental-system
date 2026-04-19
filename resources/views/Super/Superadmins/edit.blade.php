@extends("layouts.master")

@section("page")
<div class="mb-3 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Edit Super Admin: {{ $superadmin->name }}</h4>
    <a href="{{ route('super.superadmins.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row">
    <x-card title="Update Super Admin Information">
        <form action="{{ route('super.superadmins.update', $superadmin->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $superadmin->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $superadmin->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Contact Number</label>
                    <input type="text" name="contact"
                           class="form-control @error('contact') is-invalid @enderror"
                           value="{{ old('contact', $superadmin->contact) }}">
                    @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Profile Photo</label>
                    <input type="file" name="photo"
                           class="form-control @error('photo') is-invalid @enderror"
                           accept="image/*">
                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Leave blank to keep the current photo.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Account Status</label>
                    @if($superadmin->id === auth()->id())
                        <input type="hidden" name="is_active" value="1">
                        <input type="text" class="form-control bg-light" value="Active (Your own account)" disabled>
                        <small class="text-muted">You cannot deactivate your own account.</small>
                    @else
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $superadmin->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $superadmin->is_active) == 0 ? 'selected' : '' }}>Disabled / Suspended</option>
                        </select>
                    @endif
                </div>

                <div class="col-12">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-warning"><i class="fas fa-key me-2"></i>Change Password</h6>
                        <p class="fs--1 text-600 mb-2">Leave blank to keep the current password.</p>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="New Password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="password" name="password_confirmation"
                                       class="form-control" placeholder="Confirm New Password">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i> Save Super Admin
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection