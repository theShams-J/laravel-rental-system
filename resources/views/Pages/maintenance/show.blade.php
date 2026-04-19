@extends('layouts.master')

@section('page')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Maintenance Details</h1>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    @if($maintenance->status !== 'Resolved')
                        <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn btn-info">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                    @endif
                    @if(in_array($maintenance->status, ['Open', 'In Progress']))
                        <a href="{{ route('maintenance.resolve.form', $maintenance->id) }}" class="btn btn-warning">
                            <i class="fas fa-check me-2"></i>Mark Resolved
                        </a>
                    @endif
                    @if($maintenance->status === 'Resolved' && $maintenance->is_billed == 0 && $maintenance->cost_bearer === 'tenant')
                        <a href="{{ route('maintenance.bill.form', $maintenance->id) }}" class="btn btn-success">
                            <i class="fas fa-money-bill me-2"></i>Bill Tenant
                        </a>
                    @endif
                    <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column: Repair Details -->
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Repair Information</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <div class="mb-2">
                                @switch($maintenance->status)
                                    @case('Open')
                                        <span class="badge bg-warning text-dark">{{ $maintenance->status }}</span>
                                        @break
                                    @case('In Progress')
                                        <span class="badge bg-info">{{ $maintenance->status }}</span>
                                        @break
                                    @case('Resolved')
                                        <span class="badge bg-success">{{ $maintenance->status }}</span>
                                        @break
                                    @case('Cancelled')
                                        <span class="badge bg-secondary">{{ $maintenance->status }}</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <div class="mb-2">
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
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Apartment</label>
                            <div>
                                <a href="{{ route('apartments.show', $maintenance->apartment_id) }}">
                                    {{ $maintenance->apartment->name ?? 'N/A' }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Building</label>
                            <div>{{ $maintenance->apartment->building->name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <div>{{ $maintenance->title }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <div>{{ $maintenance->description ?? 'N/A' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Reported By</label>
                            <div>{{ $maintenance->reportedBy->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Assigned To</label>
                            <div>{{ $maintenance->assignedTo->name ?? 'Not Assigned' }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Vendor Name</label>
                            <div>{{ $maintenance->vendor_name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Vendor Mobile</label>
                            <div>{{ $maintenance->vendor_mobile ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Scheduled Date</label>
                            <div>{{ $maintenance->scheduled_at ? $maintenance->scheduled_at->format('d M Y, h:i A') : 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Resolved Date</label>
                            <div>{{ $maintenance->resolved_at ? $maintenance->resolved_at->format('d M Y, h:i A') : 'Not Yet Resolved' }}</div>
                        </div>
                    </div>

                    @if($maintenance->resolvedBy)
                        <div class="mb-3">
                            <label class="form-label">Resolved By</label>
                            <div>{{ $maintenance->resolvedBy->name ?? 'N/A' }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Photos Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Photos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Before Photo</label>
                            @if($maintenance->photo_before)
                                <div class="mb-2">
                                    <img src="{{ asset('img/maintenance/' . $maintenance->photo_before) }}" alt="Before" class="img-fluid rounded" style="max-width: 100%; max-height: 300px;">
                                </div>
                                <a href="{{ asset('img/maintenance/' . $maintenance->photo_before) }}" target="_blank" class="btn btn-sm btn-primary">
                                    View Full Size
                                </a>
                            @else
                                <div class="alert alert-info">No photo available</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">After Photo</label>
                            @if($maintenance->photo_after)
                                <div class="mb-2">
                                    <img src="{{ asset('img/maintenance/' . $maintenance->photo_after) }}" alt="After" class="img-fluid rounded" style="max-width: 100%; max-height: 300px;">
                                </div>
                                <a href="{{ asset('img/maintenance/' . $maintenance->photo_after) }}" target="_blank" class="btn btn-sm btn-primary">
                                    View Full Size
                                </a>
                            @else
                                <div class="alert alert-info">No photo available</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Billing Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Billing Information</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Cost</label>
                        <div class="h5 mb-0">
                            @if($maintenance->cost)
                                Rs. {{ number_format($maintenance->cost, 2) }}
                            @else
                                <span class="text-muted">Pending</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cost Bearer</label>
                        <div class="text-capitalize">{{ $maintenance->cost_bearer }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Charge Method</label>
                        <div class="text-capitalize">
                            @if($maintenance->charge_method)
                                {{ str_replace('_', ' ', $maintenance->charge_method) }}
                            @else
                                <span class="text-muted">Not yet decided</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Billed</label>
                        <div>
                            @if($maintenance->is_billed)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </div>
                    </div>

                    @if($maintenance->invoice_id)
                        <div class="mb-3">
                            <label class="form-label">Linked Invoice</label>
                            <div>
                                <a href="{{ route('invoices.show', $maintenance->invoice_id) }}" class="btn btn-sm btn-outline-primary">
                                    Invoice #{{ $maintenance->invoice->id ?? 'N/A' }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="divider"></div>

                    <div class="mb-3">
                        <label class="form-label">Created</label>
                        <div class="small text-muted">
                            {{ $maintenance->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Updated</label>
                        <div class="small text-muted">
                            {{ $maintenance->updated_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
