@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Tenant: <span class="text-primary">{{ $tenant->name }}</span></h4>
    <a href="{{ route('tenants.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Edit Tenant: {{ $tenant->name }}">
    <form action="{{ route('tenants.update', $tenant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-input name="name" label="Full Name" value="{{ $tenant->name }}" placeholder="Type Your Full Name" />
        <x-input name="nid" label="NID Number" value="{{ $tenant->nid }}" placeholder="Type NID Number" />
        <x-input name="mobile" label="Mobile" value="{{ $tenant->mobile }}" />
        <x-input name="email" label="Email" value="{{ $tenant->email }}" />
        
        <div class="mb-3">
            <x-input name="photo" label="Update Photo" type="file" />
            @if($tenant->photo)
                <div class="mt-2">
                    <small class="text-muted d-block mb-1">Current Photo:</small>
                    <img src="{{ asset('img/' . $tenant->photo) }}" alt="Tenant Photo" class="img-thumbnail" style="height: 80px;">
                </div>
            @endif
        </div>

        <x-input name="address" label="Address" type="textarea" value="{{ $tenant->address }}" />

        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-1"></i> Save Tenant
            </button>
        </div>
    </form>
</x-card>
@endsection