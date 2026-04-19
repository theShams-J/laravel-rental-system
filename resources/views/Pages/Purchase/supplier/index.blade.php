@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Supplier Management</h4>
    <a href="{{route('suppliers.create')}}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1"></span> Create New Supplier
    </a>
</div>

<x-card title="Suppliers">
<table class="table">
    @foreach($suppliers as $supplier)
    <tr>
    <td>{{$supplier->id}}</td>
    <td>{{$supplier->name}}</td>
    <td>{{$supplier->mobile}}</td>
    <td>{{$supplier->address}}</td>
    <td>
      <x-action view="suppliers/{{$supplier->id}}" edit="suppliers/{{$supplier->id}}/edit" delete="suppliers/{{$supplier->id}}/delete"></x-action>
    <td>
    </tr>
    @endforeach
     <tr>
		<td colspan="5">      
	    {{ $suppliers->links('pagination::bootstrap-5') }}     
		
		</td>
	 </tr>
    </table>
</x-card>
@endsection