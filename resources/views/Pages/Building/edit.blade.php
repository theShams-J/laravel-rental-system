@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Building: <span class="text-primary">{{ $building->name }}</span></h4>
    <a href="{{ route('buildings.index') }}" class="btn btn-falcon-default btn-sm">
        <span class="fas fa-list me-1"></span> Back to List
    </a>
</div>

<x-card title="Update Building Details">
    <form action="{{ route('buildings.update', $building->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="name">Building Name</label>
                <input class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" type="text" 
                       value="{{ old('name', $building->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="country_id">Country</label>
                <select class="form-select @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" 
                            {{ old('country_id', $building->country_id) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="city_id">City</label>
                <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" 
                            {{ old('city_id', $building->city_id) == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="address">Address</label>
                <input class="form-control @error('address') is-invalid @enderror" 
                       id="address" name="address" type="text" 
                       value="{{ old('address', $building->address) }}" required>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary px-4" type="submit">
                <i class="fas fa-save me-1"></i> Save Building
            </button>
        </div>
    </form>
</x-card>
@endsection