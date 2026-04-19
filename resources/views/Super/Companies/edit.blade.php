@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Company: {{ $company->name }}</h4>
    <a href="{{ route('super.companies.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Edit Company: {{ $company->name }}">
    <form action="{{ route('super.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf  
        @method('PUT')
        
        <div class="row">
            <div class="col-md-8">
                <x-input name="name" label="Company Name" :value="$company->name" />
                <x-input name="email" label="Email" :value="$company->email" />
                <x-input name="contact" label="Contact" :value="$company->contact" />
            </div>
            <div class="col-md-4">
                <label>Current Logo</label><br>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" class="img-thumbnail mb-2" style="width: 150px;">
                @endif
                <x-input name="logo" label="Change Logo" type="file" />
            </div>
        </div>

        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Save Company
        </button>
    </form>
</x-card>
@endsection