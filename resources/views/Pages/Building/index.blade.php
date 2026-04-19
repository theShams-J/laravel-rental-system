@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Building Management</h4>
    <a href="{{ route('buildings.create') }}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span> Create New Building
    </a>
</div>

{{-- Alert section for success/error messages --}}
@if(session('success'))
    <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">{{ session('success') }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<x-card title="All Buildings">
    <div class="table-responsive scrollbar">
        <table class="table table-hover table-striped overflow-hidden">
            <thead>
                <tr class="bg-200 text-900">
                    <th>ID</th>
                    <th>Building Name</th>
                    <th>Address</th>
                    <th>City/Country</th>
                    <th class="text-center">Total Units</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody class="vertical-align-middle">
                @foreach($buildings as $b)
                <tr>
                    <td>
                        {{$b->id}}
                    </td>
                    <td class="text-nowrap">
                        <div class="d-flex align-items-center">
                            {{-- Avatar removed from here --}}
                            <div class="flex-1">
                                <h6 class="mb-0 text-900">{{ $b->name }}</h6>
                            </div>
                        </div>
                    </td>
                    <td>{{ $b->address }}</td>
                    <td>
                        {{ $b->city->name ?? 'N/A' }}, {{ $b->country->name ?? 'N/A' }}
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill badge-soft-info">
                            {{ $b->apartments_count ?? $b->apartments->count() }} Apartments
                        </span>
                    </td>
                    <td class="text-end">
                        <x-action 
                            view="buildings/{{ $b->id }}"
                            edit="buildings/{{ $b->id }}/edit" 
                            delete="buildings/{{ $b->id }}"
                        ></x-action>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="card-footer d-flex align-items-center justify-content-center">
        {{ $buildings->links('pagination::bootstrap-5') }}
    </div>
</x-card>
@endsection