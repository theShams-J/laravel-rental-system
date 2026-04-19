@extends("layouts.master")
@section("page")


<a href="{{url('products/create')}}">
    <x-button color="primary">NEW</x-button>
</a> | <a href="{{url('products')}}">
    <x-button color="dark">BACK</x-button>
</a>
<br> <br>
<a href="{{url('products/2/edit')}}">
    <x-button color="warning">EDIT</x-button>
</a> | <a href="{{url('products/2/delete')}}">
    <x-button color="danger">DELETE</x-button>
</a> |<a href="{{url('products/2/assign')}}">
    <x-button color="success">ASSIGN</x-button>
</a>

@endsection