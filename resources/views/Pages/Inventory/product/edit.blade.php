@extends("layouts.master")
@section("page")



<form action="{{url('products/2')}}" method="post">
  @csrf  
  @method('PUT')
  <input type="text" name="name" /><br>
 <input type="submit" value="Update" />
</form>
<a href="{{url('products')}}">Back</a>

 @endsection