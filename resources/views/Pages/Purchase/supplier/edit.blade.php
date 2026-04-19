
@extends('layouts.master')
@section('page')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Supplier: {{ $supplier->name }}</h4>
    <a href="{{route('suppliers.index')}}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Edit Supplier">
<form action="{{route('suppliers.update',$supplier)}}" method ="post" enctype="multipart/form-data">
@csrf
@method("PUT")
<div class="row mb-3">
	<label for="name" class="col-sm-2 col-form-label">Name</label>
	<div class="col-sm-10">
		<input type = "text" class="form-control" name="name" value="{{$supplier->name}}" id="name" placeholder="Name">
	</div>
</div>
<div class="row mb-3">
	<label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
	<div class="col-sm-10">
		<input type = "text" class="form-control" name="mobile" value="{{$supplier->mobile}}" id="mobile" placeholder="Mobile">
	</div>
</div>
<div class="row mb-3">
	<label for="email" class="col-sm-2 col-form-label">Email</label>
	<div class="col-sm-10">
		<input type = "text" class="form-control" name="email" value="{{$supplier->email}}" id="email" placeholder="Email">
	</div>
</div>
<div class="row mb-3">
	<label for="photo" class="col-sm-2 col-form-label">Photo</label>
	<div class="col-sm-10">
		<input type = "file" class="form-control" name="photo"  id="photo" placeholder="Photo">
	</div>
</div>
<div class="row mb-3">
	<label for="address" class="col-sm-2 col-form-label">Address</label>
	<div class="col-sm-10">
		<input type = "text" class="form-control" name="address" value="{{$supplier->address}}" id="address" placeholder="Address">
	</div>
</div>

<button type="submit" class="btn btn-primary px-4">
    <i class="fas fa-save me-1"></i> Save Supplier
</button>
</form>
</x-card>
@endsection

