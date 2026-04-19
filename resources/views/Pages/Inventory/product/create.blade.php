@extends("layouts.master")
@section("page")


<form action="{{route('products.store')}}" method="post">
  @csrf  
  <input type="text" name="name" /><br>
 <input type="submit" value="Save" />
</form>
<a href="{{url('products')}}">Back</a>

@endsection