@extends('layouts.master')

@section('page')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Resolve Maintenance</h1>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <!-- Maintenance Summary -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Apartment</label>
                            <div>{{ $maintenance->apartment->name ?? 'N/A' }} ({{ $maintenance->apartment->building->name ?? 'N/A' }})</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <div>{{ $maintenance->title }}</div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <div>
                                @switch($maintenance->priority)
                                    @case('Low')
                                        <span class="badge bg-warning text-dark">{{ $maintenance->priority }}</span>
                                        @break
                                    @case('Medium')
                                        <span class="badge bg-info">{{ $maintenance->priority }}</span>
                                        @break
                                    @case('High')
                                        <span class="badge bg-warning">{{ $maintenance->priority }}</span>
                                        @break
                                    @case('Urgent')
                                        <span class="badge bg-danger">{{ $maintenance->priority }}</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <div>
                                @switch($maintenance->status)
                                    @case('Open')
                                        <span class="badge bg-warning text-dark">{{ $maintenance->status }}</span>
                                        @break
                                    @case('In Progress')
                                        <span class="badge bg-info">{{ $maintenance->status }}</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resolve Form -->
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('maintenance.resolve', $maintenance->id) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Cost -->
                        <div class="mb-3">
                            <label class="form-label" for="cost">Cost <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost" name="cost" value="{{ old('cost') }}" step="0.01" min="0" required>
                            </div>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Photo After -->
                        <div class="mb-3">
                            <label class="form-label" for="photo_after">Photo After</label>
                            <input type="file" class="form-control @error('photo_after') is-invalid @enderror" id="photo_after" name="photo_after" accept="image/*">
                            <small class="form-text text-muted">Max 2MB. Supported formats: JPEG, PNG, JPG, GIF</small>
                            @error('photo_after')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="Add any additional notes about the resolution...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="form-footer mt-4">
                            <a href="{{ route('maintenance.show', $maintenance->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-2">Mark as Resolved</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
