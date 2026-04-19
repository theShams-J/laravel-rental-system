@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Tenant</h4>
    <a href="{{ route('tenants.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Create Tenant">
    <form action="{{ route('tenants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Personal Info --}}
        <x-input name="name"          label="Full Name"         placeholder="Enter full name"    required />
        <x-input name="nid"           label="NID Number"        placeholder="Enter NID number"   required />
        <x-input name="contact"       label="Mobile"            placeholder="Enter mobile number" required />
        <x-input name="email"         label="Email"             placeholder="Enter email address" type="email" required />
        <x-input name="gender"        label="Gender"            type="select" :options="['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']" />
        <x-input name="date_of_birth" label="Date of Birth"     type="date" />
        <x-input name="profession"    label="Profession"        placeholder="Enter profession" />

        {{-- Address --}}
        <x-input name="address"       label="Address"           type="textarea" placeholder="Enter address" />
        <x-input name="city"          label="City"              placeholder="Enter city" />
        <x-input name="postcode"      label="Postcode"          placeholder="Enter postcode" />

        {{-- Country --}}
        <div class="mb-3">
    <label for="country_id" class="form-label">Country</label>
    <select name="country_id" id="country_id" class="form-select {{ $errors->has('country_id') ? 'is-invalid' : '' }}">
        <option value="">-- Select Country --</option>
        @foreach($countries as $country)
            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                {{ $country->name }}
            </option>
        @endforeach
    </select>
    @error('country_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

        {{-- Emergency Contact --}}
        <x-input name="emergency_contact_name"     label="Emergency Contact Name"     placeholder="Enter name" />
        <x-input name="emergency_contact_mobile"   label="Emergency Contact Mobile"   placeholder="Enter mobile" />
        <x-input name="emergency_contact_relation" label="Emergency Contact Relation" placeholder="e.g. Brother, Father" />

        {{-- Documents & Photo --}}
        <x-input name="photo"     label="Photo"     type="file" accept="image/*" />
        <x-input name="nid_front" label="NID Front" type="file" accept="image/*" />
        <x-input name="nid_back"  label="NID Back"  type="file" accept="image/*" />

        {{-- Remarks --}}
        <x-input name="remarks" label="Remarks" type="textarea" placeholder="Any additional remarks" />

        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-1"></i> Save Tenant
            </button>
        </div>

    </form>
</x-card>
@endsection