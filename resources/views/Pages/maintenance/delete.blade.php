@extends('layouts.master')

@section('page')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Delete Maintenance</h1>
            </div>
        </div>
    </div>

    <!-- Confirmation Card -->
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    </div>

                    <h3 class="mb-3">Confirm Deletion</h3>
                    <p class="text-muted mb-4">
                        Are you sure you want to delete this maintenance record? This action cannot be undone.
                    </p>

                    <!-- Maintenance Summary -->
                    <div class="alert alert-light text-start mb-4">
                        <div class="row mb-2">
                            <div class="col-6">
                                <strong>Apartment:</strong>
                            </div>
                            <div class="col-6">
                                {{ $maintenance->apartment->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <strong>Title:</strong>
                            </div>
                            <div class="col-6">
                                {{ $maintenance->title }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-6">
                                {{ $maintenance->status }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <strong>Cost:</strong>
                            </div>
                            <div class="col-6">
                                Rs. {{ number_format($maintenance->cost ?? 0, 2) }}
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-list justify-content-center">
                        <a href="{{ route('maintenance.show', $maintenance->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <form method="POST" action="{{ route('maintenance.destroy', $maintenance->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Delete Permanently
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
