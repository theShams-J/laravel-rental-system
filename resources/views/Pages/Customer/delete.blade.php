<form action="{{route('customer.destroy',2)}}" method="post">
  @csrf  
  @method('DELETE')
 <input type="submit" value="Delete" />
</form>
<a href="{{url('customer')}}">Back</a>