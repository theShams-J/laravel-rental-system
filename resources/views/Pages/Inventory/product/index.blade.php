@extends("layouts.master")
@section("page")

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Product Management</h4>
    <a href="{{url('products/create')}}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1"></span> Create New Product
    </a>
</div>
1. Apple <a href="{{url('products/2')}}">
    <x-button color="info">DETAILS</x-button>
</a>
 <!-- <a href="{{url('products/2/edit')}}">Edit</a> | <a href="{{url('products/2/delete')}}">Delete</a>  -->

@endsection