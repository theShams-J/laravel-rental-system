@extends("layouts.master")

@section("page")
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">{{ $building->name }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('buildings.index') }}">Buildings</a></li>
                <li class="breadcrumb-item active">View Details</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('buildings.edit', $building->id) }}" class="btn btn-falcon-default btn-sm me-2">
            <span class="fas fa-pencil-alt me-1"></span> Edit
        </a>
        <a href="{{ route('buildings.index') }}" class="btn btn-falcon-primary btn-sm">
            <span class="fas fa-list me-1"></span> Back to List
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <x-card title="Building Overview" class="mb-3">
            <div class="row align-items-center p-3">
                <div class="col-auto">
                    <div class="avatar avatar-4xl bg-soft-primary text-primary rounded-circle">
                        <div class="avatar-name fs-2"><span>{{ substr($building->name, 0, 1) }}</span></div>
                    </div>
                </div>
                <div class="col border-start ms-3">
                    <h5 class="mb-1 text-primary">{{ $building->name }}</h5>
                    <p class="mb-0 text-700">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                        {{ $building->address }}, {{ $building->city->name ?? 'N/A' }}, {{ $building->country->name ?? 'N/A' }}
                    </p>
                </div>
            </div>
            
            <hr class="my-0">
            
            <div class="row g-0">
                <div class="col-md-4 border-end border-bottom border-md-bottom-0 p-3 text-center">
                    <p class="text-500 mb-1">Total Units</p>
                    <h4 class="mb-0">{{ $building->apartments->count() }}</h4>
                </div>
                <div class="col-md-4 border-end border-bottom border-md-bottom-0 p-3 text-center">
                    <p class="text-500 mb-1">Registered On</p>
                    <h4 class="mb-0">{{ $building->created_at->format('M d, Y') }}</h4>
                </div>
                <div class="col-md-4 p-3 text-center">
                    <p class="text-500 mb-1">Status</p>
                    <h4 class="mb-0"><span class="badge rounded-pill badge-soft-success">Active</span></h4>
                </div>
            </div>
        </x-card>

        <x-card title="Associated Apartments / Units">
            <div class="table-responsive scrollbar">
                <table class="table table-sm table-hover table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-2">Unit Name</th>
                            <th class="py-2">Floor No</th>
                            <th class="py-2">Type</th>
                            <th class="py-2 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($building->apartments as $apt)
                        <tr class="align-middle">
                            <td class="fw-bold">{{ $apt->name }}</td>
                            <td>{{ $apt->floor_no ?? 'Ground' }}</td>
                            <td><span class="badge badge-soft-info">{{ $apt->type ?? 'Residential' }}</span></td>
                            <td class="text-end">
                                <a href="{{ url('apartments/'.$apt->id) }}" class="btn btn-falcon-default btn-xs">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="{{ asset('assets/img/icons/spot-illustrations/empty.png') }}" alt="" width="60" class="mb-2"><br>
                                <span class="text-500 italic">No apartments found for this building.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>
@endsection