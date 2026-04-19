@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Company</h4>
    <a href="{{ route('super.companies.index') }}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Create Company">
    <form action="{{ route('super.companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <x-input name="name" label="Company Name" placeholder="Type Company Name" required />
            </div>
            <div class="col-md-6">
                <x-input name="email" label="Email Address" type="email" />
            </div>
            <div class="col-md-6">
                <x-input name="contact" label="Contact Number" />
            </div>
            <div class="col-md-6">
                <x-input name="website" label="Website URL" />
            </div>
            
            <div class="col-md-4">
                <x-input name="city" label="City" />
            </div>
            <div class="col-md-4">
                <x-input name="area" label="Area" />
            </div>
            <div class="col-md-4">
                <x-input name="post_code" label="Post Code" />
            </div>

            <div class="col-md-12">
                <x-input name="street_address" label="Street Address" type="textarea" />
            </div>

            <div class="col-md-6">
                <x-input name="bin" label="BIN" />
            </div>
            <div class="col-md-6">
                <x-input name="trade_license" label="Trade License" />
            </div>
            <div class="col-md-12">
                <x-input name="tagline" label="Company Tagline" />
            </div>
            <div class="col-md-12">
                <x-input name="logo" label="Company Logo" type="file" />
            </div>
        </div>

        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Save Company
        </button>
    </form>
</x-card>
@endsection