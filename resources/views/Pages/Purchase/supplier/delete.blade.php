@extends("layouts.master")
@section('page')
<a class='btn btn-success mb-2' href="{{route('suppliers.index')}}">Manage</a>
<x-card title="View Supplier">
<table class='table table-striped text-nowrap'>
<tbody>
		<tr><th>Id</th><td>{{$supplier->id}}</td></tr>
		<tr><th>Name</th><td>{{$supplier->name}}</td></tr>
		<tr><th>Mobile</th><td>{{$supplier->mobile}}</td></tr>
		<tr><th>Email</th><td>{{$supplier->email}}</td></tr>
		<tr><th>Photo</th><td><img src="{{asset('img/'.$supplier->photo)}}" width="100" /></td></tr>
		<tr><th>Address</th><td>{{$supplier->address}}</td></tr>

</tbody>
</table>
<form  action="{{route('suppliers.destroy',$supplier)}}" method="POST">
    @csrf
    @method("DELETE")
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
</x-card>
@endsection

