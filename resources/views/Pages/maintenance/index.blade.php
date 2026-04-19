@extends('layouts.master')

@section('page')
<div class="content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Maintenance Management</h1>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Report Repair
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="card mb-3">
        <div class="card-body">
            <nav class="nav nav-pills" role="tablist">
                <a href="{{ route('maintenance.index') }}" class="nav-link {{ !request('status') ? 'active' : '' }}">
                    All
                </a>
                <a href="{{ route('maintenance.index', ['status' => 'Open']) }}" class="nav-link {{ request('status') === 'Open' ? 'active' : '' }}">
                    Open
                </a>
                <a href="{{ route('maintenance.index', ['status' => 'In Progress']) }}" class="nav-link {{ request('status') === 'In Progress' ? 'active' : '' }}">
                    In Progress
                </a>
                <a href="{{ route('maintenance.index', ['status' => 'Resolved']) }}" class="nav-link {{ request('status') === 'Resolved' ? 'active' : '' }}">
                    Resolved
                </a>
            </nav>
        </div>
    </div>

    <!-- Maintenance Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Apartment</th>
                        <th>Building</th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Cost</th>
                        <th>Cost Bearer</th>
                        <th>Billed</th>
                        <th class="w-1">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenance as $record)
                        <tr>
                            <td class="text-muted">{{ $record->id }}</td>
                            <td>
                                <div class="text-truncate">
                                    <a href="{{ route('apartments.show', $record->apartment_id) }}">
                                        {{ $record->apartment->name ?? 'N/A' }}
                                    </a>
                                </div>
                            </td>
                            <td>{{ $record->apartment->building->name ?? 'N/A' }}</td>
                            <td>
                                <div class="text-truncate">
                                    {{ $record->title }}
                                </div>
                            </td>
                            <td>
                                @switch($record->priority)
                                    @case('Low')
                                        <span class="badge bg-warning text-dark">{{ $record->priority }}</span>
                                        @break
                                    @case('Medium')
                                        <span class="badge bg-info">{{ $record->priority }}</span>
                                        @break
                                    @case('High')
                                        <span class="badge bg-warning">{{ $record->priority }}</span>
                                        @break
                                    @case('Urgent')
                                        <span class="badge bg-danger">{{ $record->priority }}</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @switch($record->status)
                                    @case('Open')
                                        <span class="badge bg-warning text-dark">{{ $record->status }}</span>
                                        @break
                                    @case('In Progress')
                                        <span class="badge bg-info">{{ $record->status }}</span>
                                        @break
                                    @case('Resolved')
                                        <span class="badge bg-success">{{ $record->status }}</span>
                                        @break
                                    @case('Cancelled')
                                        <span class="badge bg-secondary">{{ $record->status }}</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                Rs. {{ number_format($record->cost, 2) }}
                            </td>
                            <td>
                                <span class="text-capitalize">{{ $record->cost_bearer }}</span>
                            </td>
                            <td>
                                @if($record->is_billed)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('maintenance.show', $record->id) }}" class="btn btn-sm btn-ghost-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($record->status !== 'Resolved')
                                        <a href="{{ route('maintenance.edit', $record->id) }}" class="btn btn-sm btn-ghost-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                    @if($record->status === 'Resolved' && $record->is_billed == 0 && $record->cost_bearer === 'tenant')
                                        <a href="{{ route('maintenance.bill.form', $record->id) }}" class="btn btn-sm btn-ghost-success">
                                            <i class="fas fa-money-bill"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('maintenance.delete', $record->id) }}" class="btn btn-sm btn-ghost-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                No maintenance records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($maintenance->hasPages())
            <div class="card-footer d-flex align-items-center">
                {{ $maintenance->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
