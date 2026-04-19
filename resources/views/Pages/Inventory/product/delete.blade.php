@expends("layouts.master")
@section("page")
<form action="{{route('products.destroy',2)}}" method="post">
  @csrf  
  @method('DELETE')
 <input type="submit" value="Delete" />
</form>
<a href="{{url('products')}}">Back</a>

@endsection