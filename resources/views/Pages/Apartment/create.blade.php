@extends("layouts.master")
@section("page")

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Apartment</h4>
    <a href="{{url('apartments')}}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<x-card title="Create Apartment">
  <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <x-input name="apartment_no" label="Apartment Number" placeholder="e.g. A-101" />

    {{-- Building Selection --}}
    <div class="mb-3">
        <label class="form-label">Building</label>
        <select name="building_id" class="form-control">
            <option value="">Select Building</option>
            @foreach($buildings as $building)
                <option value="{{ $building->id }}">{{ $building->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Type Selection --}}
    <div class="mb-3">
        <label class="form-label">Apartment Type</label>
        <select name="type_id" class="form-control">
            <option value="">Select Type</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <x-input name="floor" label="Floor" placeholder="e.g. 4" />
    <x-input name="rent" label="Monthly Rent" />
    <x-input name="size_sqft" label="Size (Sqft)" />
    <x-input name="photo" label="Apartment Photo" type="file" />

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="Available">Available</option>
            <option value="Occupied">Occupied</option>
            <option value="Maintenance">Maintenance</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary px-4">
        <i class="fas fa-save me-1"></i> Save Apartment
    </button>
  </form>

  
</x-card>
@endsection