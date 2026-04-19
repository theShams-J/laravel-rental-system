@extends("layouts.master")
@section('page')
{{-- 1. Updated Route Name --}}
<div class="d-flex justify-content-end align-items-end mb-3">
    <a href="{{ route('apartments.index') }}" class="btn btn-falcon-primary btn-sm">
        <span class="fas fa-list me-1" data-fa-transform="shrink-3"></span >Back To Apartment List</a>
</div>

{{-- 2. Updated Title --}}
<x-card title="View Apartment Detail">
    {{-- ASSIGN BUTTON ADDED HERE --}}
    <div class="mb-3 text-right">
        @if($apartment->status == 'Available')
            <a href="{{ route('leases.create', ['apartment_id' => $apartment->id]) }}" class="btn btn-primary">
                <i class="fa fa-user-plus"></i> Assign Tenant
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                <i class="fa fa-ban"></i> {{ $apartment->status }}
            </button>
        @endif
    </div>

    <table class='table table-striped'>
        <tbody>
            {{-- 3. Displaying Joined Data using Relationships --}}
            <tr><th>Id</th><td>{{$apartment->id}}</td></tr>
            <tr><th>Apartment No</th><td>{{$apartment->apartment_no}}</td></tr>
            
            {{-- Showing Name instead of ID --}}
            <tr><th>Building</th><td>{{$apartment->building->name ?? 'N/A'}}</td></tr>
            <tr><th>Type</th><td>{{$apartment->apartmentType->name ?? 'N/A'}}</td></tr>
            
            <tr><th>Floor</th><td>{{$apartment->floor}}</td></tr>
            <tr><th>Rent</th><td>${{ number_format($apartment->rent, 2) }}</td></tr>
            <tr><th>Size (Sqft)</th><td>{{$apartment->size_sqft}}</td></tr>
            
            {{-- 4. Updated Image Path --}}
            <tr>
                <th>Photo</th>
                <td>
                    @if($apartment->photo)
                        <img src="{{asset('img/apartments/'.$apartment->photo)}}" width="150" class="img-thumbnail" />
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
            </tr>
            <tr><th>Status</th><td>{{$apartment->status}}</td></tr>

        </tbody>
    </table>
</x-card>
@endsection