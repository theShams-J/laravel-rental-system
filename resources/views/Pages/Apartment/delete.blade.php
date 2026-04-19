@extends("layouts.master")
@section('page')
<a class='btn btn-secondary mb-2' href="{{route('apartments.index')}}">Back to List</a>

<x-card title="Delete Apartment">
    <div class="alert alert-danger">
        Are you sure you want to delete this apartment? This action cannot be undone.
    </div>

    <table class='table table-striped table-bordered'>
        <tbody>
            <tr><th>Id</th><td>{{$apartment->id}}</td></tr>
            <tr><th>Apartment No</th><td>{{$apartment->apartment_no}}</td></tr>
            
            {{-- Displaying Names instead of IDs --}}
            <tr><th>Building</th><td>{{$apartment->building->name ?? 'N/A'}}</td></tr>
            <tr><th>Type</th><td>{{$apartment->apartmentType->name ?? 'N/A'}}</td></tr>
            
            <tr><th>Rent</th><td>${{ number_format($apartment->rent, 2) }}</td></tr>
            <tr><th>Photo</th><td><img src="{{asset('img/apartments/'.$apartment->photo)}}" width="100" /></td></tr>
        </tbody>
    </table>

    {{-- Delete Form --}}
    <form action="{{route('apartments.destroy', $apartment->id)}}" method="POST">
        @csrf
        @method("DELETE")
        <button type="submit" class="btn btn-danger">Confirm Delete</button>
        <a href="{{route('apartments.index')}}" class="btn btn-secondary">Cancel</a>
    </form>
</x-card>
@endsection