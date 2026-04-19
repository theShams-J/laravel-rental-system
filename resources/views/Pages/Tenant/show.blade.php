@extends("layouts.master")
@section('page')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Tenant Name: <span class="text-primary">{{ $tenant->name }}</span></h4>
    <a href="{{ route('tenants.index') }}" class="btn btn-falcon-default btn-sm">
        <span class="fas fa-list me-1"></span> Back to List
    </a>
</div>


<x-card title="View Tenant">
    <div class="mb-2">
    
    {{-- NEW: Button to view this specific tenant's dashboard view --}}
    <a class='btn btn-info' href="{{ route('tenant.dashboard', ['tenant_id' => $tenant->id]) }}">
        <span class="fas fa-user-shield me-1"></span> View Dashboard
    </a>

    <a href="{{ route('leases.create', ['tenant_id' => $tenant->id]) }}">
        <x-button color="success">Assign Apartment</x-button>
    </a>
</div>
<table class='table table-striped text-nowrap'>
<tbody>
        <tr><th>Id</th><td>{{$tenant->id}}</td></tr>
        <tr><th>Name</th><td>{{$tenant->name}}</td></tr>
        <tr><th>NID</th><td>{{$tenant->nid}}</td></tr>
        <tr><th>Mobile</th><td>{{$tenant->mobile}}</td></tr>
        <tr><th>Email</th><td>{{$tenant->email}}</td></tr>
        <tr><th>Photo</th><td><img src="{{asset('img/'.$tenant->photo)}}" width="100" /></td></tr>
        <tr><th>Address</th><td>{{$tenant->address}}</td></tr>
</tbody>
</table>
</x-card>
@endsection