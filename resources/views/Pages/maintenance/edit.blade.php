@extends('layouts.master')

@section('page')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Edit Maintenance</h1>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('maintenance.update', $maintenance->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $maintenance->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $maintenance->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div class="mb-3">
                            <label class="form-label" for="priority">Priority <span class="text-danger">*</span></label>
                            <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                <option value="Low" {{ old('priority', $maintenance->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('priority', $maintenance->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ old('priority', $maintenance->priority) == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Urgent" {{ old('priority', $maintenance->priority) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="Open" {{ old('status', $maintenance->status) == 'Open' ? 'selected' : '' }}>Open</option>
                                <option value="In Progress" {{ old('status', $maintenance->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ old('status', $maintenance->status) == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="Cancelled" {{ old('status', $maintenance->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Assigned To -->
                        <div class="mb-3">
                            <label class="form-label" for="assigned_to">Assigned To</label>
                            <select class="form-control @error('assigned_to') is-invalid @enderror" id="assigned_to" name="assigned_to">
                                <option value="">-- Not Assigned --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $maintenance->assigned_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vendor Name -->
                        <div class="mb-3">
                            <label class="form-label" for="vendor_name">Vendor Name</label>
                            <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="vendor_name" name="vendor_name" value="{{ old('vendor_name', $maintenance->vendor_name) }}">
                            @error('vendor_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vendor Mobile -->
                        <div class="mb-3">
                            <label class="form-label" for="vendor_mobile">Vendor Mobile</label>
                            <input type="text" class="form-control @error('vendor_mobile') is-invalid @enderror" id="vendor_mobile" name="vendor_mobile" value="{{ old('vendor_mobile', $maintenance->vendor_mobile) }}">
                            @error('vendor_mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Scheduled At -->
                        <div class="mb-3">
                            <label class="form-label" for="scheduled_at">Scheduled Date & Time</label>
                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at', $maintenance->scheduled_at ? $maintenance->scheduled_at->format('Y-m-d\TH:i') : '') }}">
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="form-footer mt-4">
                            <a href="{{ route('maintenance.show', $maintenance->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-2">Update Maintenance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
