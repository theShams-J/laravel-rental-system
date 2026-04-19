@extends("layouts.master")
@section("page")

<div class="mb-3">
    <a href="{{ route('super.companies.create') }}">
        <x-button color="primary">NEW</x-button>
    </a>
    |
    <a href="{{ route('super.companies.index') }}">
        <x-button color="dark">BACK</x-button>
    </a> 
</div>

<x-card title="Company Details">
    <div class="row">
        <div class="col-md-3 text-center">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="rounded shadow-sm" style="width: 100%;">
            @endif
            <h4 class="mt-3">{{ $company->name }}</h4>
            <span class="badge {{ $company->is_active ? 'bg-success' : 'bg-danger' }}">
                {{ $company->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="col-md-9">
            <table class="table table-bordered">
                <tr><th>BIN</th><td>{{ $company->bin }}</td></tr>
                <tr><th>Trade License</th><td>{{ $company->trade_license }}</td></tr>
                <tr><th>Email</th><td>{{ $company->email }}</td></tr>
                <tr><th>Contact</th><td>{{ $company->contact }}</td></tr>
                <tr><th>Website</th><td>{{ $company->website }}</td></tr>
                <tr><th>Address</th><td>{{ $company->street_address }}, {{ $company->area }}, {{ $company->city }}</td></tr>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('super.companies.edit', $company->id) }}">
            <x-button color="warning">EDIT</x-button>
        </a> 
        | 
        <a href="{{ route('super.companies.delete', $company->id) }}">
            <x-button color="danger">Delete</x-button>
        </a>
    </div>
</x-card>

@endsection