@extends('layouts.master')

@section('page')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Report Maintenance</h1>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('maintenance.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Apartment Selection -->
                        <div class="mb-3">
                            <label class="form-label" for="apartment_id">Apartment <span class="text-danger">*</span></label>
                            <select class="form-control @error('apartment_id') is-invalid @enderror" id="apartment_id" name="apartment_id" required>
                                <option value="">-- Select Apartment --</option>
                                @foreach($apartments as $apartment)
    <option value="{{ $apartment->id }}" {{ old('apartment_id') == $apartment->id ? 'selected' : '' }}>
        {{ $apartment->full_name }}
    </option>
@endforeach
                            </select>
                            @error('apartment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div class="mb-3">
                            <label class="form-label" for="priority">Priority <span class="text-danger">*</span></label>
                            <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                <option value="">-- Select Priority --</option>
                                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cost Bearer -->
                        <div class="mb-3">
                            <label class="form-label" for="cost_bearer">Cost Bearer <span class="text-danger">*</span></label>
                            <select class="form-control @error('cost_bearer') is-invalid @enderror" id="cost_bearer" name="cost_bearer" required>
                                <option value="">-- Select Cost Bearer --</option>
                                <option value="company" {{ old('cost_bearer') == 'company' ? 'selected' : '' }}>Company</option>
                                <option value="tenant" {{ old('cost_bearer') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                            </select>
                            @error('cost_bearer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vendor Name -->
                        <div class="mb-3">
                            <label class="form-label" for="vendor_name">Vendor Name</label>
                            <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="vendor_name" name="vendor_name" value="{{ old('vendor_name') }}">
                            @error('vendor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vendor Mobile -->
                        <div class="mb-3">
                            <label class="form-label" for="vendor_mobile">Vendor Mobile</label>
                            <input type="text" class="form-control @error('vendor_mobile') is-invalid @enderror" id="vendor_mobile" name="vendor_mobile" value="{{ old('vendor_mobile') }}">
                            @error('vendor_mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Scheduled At -->
                        <div class="mb-3">
                            <label class="form-label" for="scheduled_at">Scheduled Date & Time</label>
                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}">
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Photo Before -->
                        <div class="mb-3">
                            <label class="form-label" for="photo_before">Photo Before</label>
                            <input type="file" class="form-control @error('photo_before') is-invalid @enderror" id="photo_before" name="photo_before" accept="image/*">
                            <small class="form-text text-muted">Max 2MB. Supported formats: JPEG, PNG, JPG, GIF</small>
                            @error('photo_before')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="form-footer mt-4">
                            <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-2">Create Maintenance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
