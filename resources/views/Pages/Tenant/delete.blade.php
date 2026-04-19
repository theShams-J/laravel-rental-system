@extends("layouts.master")
@section('page')
<a class='btn btn-success mb-2' href="{{route('tenants.index')}}">Manage</a>
<x-card title="Delete Tenent">
<table class='table table-striped text-nowrap'>
<tbody>
		<tr><th>Id</th><td>{{$tenant->id}}</td></tr>
		<tr><th>Name</th><td>{{$tenant->name}}</td></tr>
    <tr><th>NID</th><td>{{$tenant->nid}}</td></tr>
		<tr><th>Mobile</th><td>{{$tenant->mobile}}</td></tr>
		<tr><th>Email</th><td>{{$tenant->email}}</td></tr>
		<tr><th>Photo</th><td><img src="{{asset('img/'.$tenant->photo)}}" width="100" /></td></tr>
		<tr><th>Address</th><td>{{$tenant->address}}</td></tr>

</tbody>
</table>
<form  action="{{route('tenants.destroy',$tenant)}}" method="POST">
    @csrf
    @method("DELETE")
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
</x-card>
@endsection

