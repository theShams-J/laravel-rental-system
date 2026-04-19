@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Supplier</h4>
    <a href="{{route('suppliers.index')}}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Create Supplier">
<form action="{{route('suppliers.store')}}" method ="post" enctype="multipart/form-data">
@csrf
<x-input label="Name" name="name" placeholder="Name"></x-input>

<div class="row mb-3">
	<label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
	<div class="col-sm-10">
		<input type = "text" class="form-control" name="mobile" id="mobile" placeholder="Mobile">
	</div>
</div>

<div class="row mb-3">
	<label for="email" class="col-sm-2 col-form-label">Email</label>
	<div class="col-sm-10">
		<input type = "text" class="form-control" name="email" id="email" placeholder="Email">
	</div>
</div>
<div class="row mb-3">
	<label for="photo" class="col-sm-2 col-form-label">Photo</label>
	<div class="col-sm-10">
		<input type = "file" class="form-control" name="photo" id="photo" placeholder="Photo">
	</div>
</div>
<div class="row mb-3">
	<label for="address" class="col-sm-2 col-form-label">Address</label>
	<div class="col-sm-10">
		<textarea class="form-control" name="address" id="address" placeholder="Address"></textarea>
	</div>
</div>
<button type="submit" class="btn btn-primary px-4">Save Supplier</button>
</form>
</x-card>
@endsection