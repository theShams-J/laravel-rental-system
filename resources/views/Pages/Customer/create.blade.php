@extends("layouts.master")
@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Create New Customer</h4>
    <a href="{{url('customer')}}" class="btn btn-falcon-default btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to List
    </a>
</div>
<x-card title="Create Customer">
  <form action="{{ route('customer.store') }}" method="POST">
    @csrf

<x-radio 
    name="gender" 
    label="Gender" 
    :options="['male' => 'Male', 'female' => 'Female']" 
    selected="male" 
/>
<x-input name="name" label="Full Name" placeholder="Type Your Full Name" />
<x-input name="mobile" label="Mobile" />
<x-input name="email" label="Email" />
<x-input name="photo" label="Upload Photo" type="file" />
<x-input name="address" label="Address" type="textarea" />

<button type="submit" class="btn btn-primary px-4">
    <i class="fas fa-save me-1"></i> Save Customer
</button>


  </form>

<!-- <form action="{{route('customer.store')}}" method="post">
  @csrf  
  <input type="text" name="name" /><br>
 <input type="submit" value="Save" />
</form>
<a href="{{url('customer')}}">Back</a> -->
</x-card>
@endsection