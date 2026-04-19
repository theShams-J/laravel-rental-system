@extends("layouts.master")
@section("page")

<a href="{{url('products')}}">
    <x-button color="dark">BACK</x-button>
</a> <br> <br>

<form action="{{route('products.store')}}" method="post">
  @csrf  
  <input type="text" name="name" /><br>
 <input type="submit" value="Save" />
</form>

<!-- <form action="{{url('products/2')}}" method="post">
  @csrf  
  @method('PUT')
  <input type="text" name="name" /><br>
 <input type="submit" value="Update" />
</form> -->
 @endsection