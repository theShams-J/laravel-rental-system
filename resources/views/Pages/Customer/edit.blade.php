@extends("layouts.master")
@section("page")

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Edit Customer</h4>
    <a href="{{url('customer')}}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>

<x-card title="Edit Customer">
  <form action="{{url('customer/2')}}" method="post">
  @csrf  
  @method('PUT')
  <input type="text" name="name" /><br>
  <button type="submit" class="btn btn-primary px-4 mt-3">
    <i class="fas fa-save me-1"></i> Save Customer
  </button>
</form>
</x-card>

@endsection