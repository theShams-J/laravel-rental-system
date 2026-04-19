@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Apartment: {{ $apartment->apartment_no }}</h4>
    <a href="{{route('apartments.index')}}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Edit Apartment">
  {{-- 1. Use the route for update, passing the model instance --}}
  <form action="{{ route('apartments.update', $apartment->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') {{-- 2. Required for updates --}}

    {{-- 3. Populate existing data using the :value attribute --}}
    <x-input name="apartment_no" label="Apartment Number" :value="$apartment->apartment_no" />

    {{-- Building Selection --}}
    <div class="mb-3">
        <label class="form-label">Building</label>
        <select name="building_id" class="form-control">
            @foreach($buildings as $building)
                {{-- 4. Check if this is the currently selected building --}}
                <option value="{{ $building->id }}" {{ $apartment->building_id == $building->id ? 'selected' : '' }}>
                    {{ $building->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Type Selection --}}
    <div class="mb-3">
        <label class="form-label">Apartment Type</label>
        <select name="type_id" class="form-control">
            @foreach($types as $type)
                <option value="{{ $type->id }}" {{ $apartment->type_id == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
    </div>

    <x-input name="floor" label="Floor" :value="$apartment->floor" />
    <x-input name="rent" label="Monthly Rent" :value="$apartment->rent" />
    <x-input name="size_sqft" label="Size (Sqft)" :value="$apartment->size_sqft" />
    
    {{-- Display current photo --}}
    <div class="mb-3">
        <label class="form-label">Current Photo</label><br>
        @if($apartment->photo)
            <img src="{{asset('img/apartments/'.$apartment->photo)}}" width="100" class="img-thumbnail mb-2" />
        @endif
        <x-input name="photo" label="Replace Photo" type="file" />
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
            <option value="Available" {{ $apartment->status == 'Available' ? 'selected' : '' }}>Available</option>
            <option value="Occupied" {{ $apartment->status == 'Occupied' ? 'selected' : '' }}>Occupied</option>
            <option value="Maintenance" {{ $apartment->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary px-4">
        <i class="fas fa-save me-1"></i> Save Apartment
    </button>
  </form>
</x-card>
@endsection