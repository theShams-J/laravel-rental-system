@extends("layouts.master")

@section("page")
<div class="mb-3 d-flex justify-content-between align-items-center">
    <h4 class="mb-0">Create New User</h4>
    <a href="{{ route('users.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row justify-content-center">
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <x-card title="Account Security & Identity">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="e.g. John Doe" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="name@company.com" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Contact Number</label>
                    <input type="text" name="contact"
                           class="form-control @error('contact') is-invalid @enderror"
                           placeholder="e.g. 01711000000" value="{{ old('contact') }}">
                    @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Profile Photo</label>
                    <input type="file" name="photo"
                           class="form-control @error('photo') is-invalid @enderror"
                           accept="image/*">
                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">User Role</label>
                    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                        <option value="">-- Select a Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    <i class="fas fa-save me-1"></i> Save User
                </button>
            </div>
        </x-card>

    </form>
</div>
@endsection