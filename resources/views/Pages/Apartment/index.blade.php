@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Apartment Management</h4>
    <a class='btn btn-primary btn-sm' href="{{route('apartments.create')}}">
        <span class="fas fa-plus me-1"></span> Create New Apartment
    </a>
</div>

<x-card title="Apartments List">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Apartment No</th>
                <th>Building</th> {{-- Updated Header --}}
                <th>Type</th>     {{-- Updated Header --}}
                <th>Rent</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($apartments as $apartment)
            <tr>
                <td>{{$apartment->id}}</td>
                <td>
                    @if($apartment->photo)
                        <img src="{{asset('img/apartments/'.$apartment->photo)}}" width="70" class="img-thumbnail" />
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{$apartment->apartment_no}}</td>
                
                {{-- Displaying Joined Data using Relationships --}}
                <td>{{$apartment->building->name ?? 'N/A'}}</td>
                <td>{{$apartment->apartmentType->name ?? 'N/A'}}</td>
                
                <td>${{ number_format($apartment->rent, 2) }}</td>
                <td>
                    <span class="badge 
                        {{ $apartment->status == 'Available' ? 'bg-success' : '' }}
                        {{ $apartment->status == 'Occupied' ? 'bg-danger' : '' }}
                        {{ $apartment->status == 'Maintenance' ? 'bg-warning' : '' }}">
                        {{$apartment->status}}
                    </span>
                </td>
                <td>
                    <x-action 
                        view="apartments/{{ $apartment->id }}"
                        edit="apartments/{{ $apartment->id }}/edit" 
                        delete="apartments/{{ $apartment->id }}"
                    ></x-action>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                    {{-- Pagination Links --}}
                    {{ $apartments->links('pagination::bootstrap-5') }} 
                </td>
            </tr>
        </tfoot>
    </table>
</x-card>
@endsection