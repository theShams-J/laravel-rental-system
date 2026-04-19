@extends("layouts.master")
@section("page")


<a href="{{url('customer/create')}}">
    <x-button color="primary">NEW</x-button>
</a>
|
<a href="{{url('customer')}}">
    <x-button color="dark">BACK</x-button>
</a> 
<br> <br>
<a href="{{url('customer/2/edit')}}">
    <x-button color="warning">EDIT</x-button>
</a> | <a href="{{url('customer/2/delete')}}">
    <x-button color="danger">Delete</x-button>
</a>

 @endsection