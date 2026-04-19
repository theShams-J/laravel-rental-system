@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Building</h4>
    <a href="{{ route('buildings.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<x-card title="Building Information">
    <form action="{{ route('buildings.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="name">Building Name</label>
                <input class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" type="text" placeholder="e.g. Skyline Apartments" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="country_id">Country</label>
                <select class="form-select @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="city_id">City</label>
                <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="address">Full Address</label>
                <input class="form-control @error('address') is-invalid @enderror" 
                       id="address" name="address" type="text" placeholder="Street, Block, etc." value="{{ old('address') }}" required>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mt-3 border-top pt-3">
            <button class="btn btn-primary px-4" type="submit">
                <i class="fas fa-save me-1"></i> Save Building
            </button>
        </div>
    </form>
</x-card>
@endsection