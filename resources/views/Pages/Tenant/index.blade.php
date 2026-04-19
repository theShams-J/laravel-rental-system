@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Tenant Management</h4>
    <a class='btn btn-primary btn-sm' href="{{route('tenants.create')}}">
        <i class="fas fa-plus me-1"></i> Create New Tenant
    </a>
</div>

{{-- --- ALERT SECTION START --- --}}
@if(session('success'))
    <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">{{ session('success') }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
        <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1 fw-bold">{{ session('error') }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- --- ALERT SECTION END --- --}}

<x-card title="Tenants List">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Name</th>
                <th>NID</th>
                <th>Mobile</th>
                <th>Address</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tenants as $tenant)
            <tr>
                <td>{{$tenant->id}}</td>
                <td>
                    <img src="{{ $tenant->photo ? asset('img/'.$tenant->photo) : asset('assets/img/team/avatar.png') }}" 
                         width="50" class="rounded-circle border" />
                </td>
                <td class="fw-semi-bold">{{$tenant->name}}</td>
                <td>{{$tenant->nid}}</td>
                <td>{{$tenant->mobile}}</td>
                <td>{{$tenant->address}}</td>
                <td class="text-end">
                    <x-action 
                        view="tenants/{{ $tenant->id }}"
                        edit="tenants/{{ $tenant->id }}/edit" 
                        delete="tenants/{{ $tenant->id }}"
                    ></x-action>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="pt-3">      
                    {{ $tenants->links('pagination::bootstrap-5') }}     
                </td>
            </tr>
        </tfoot>
    </table>
</x-card>
@endsection

<!-- <a href="{{url('tenant/2/delete')}}">
    <x-button color="danger">Delete</x-button>
</a> -->