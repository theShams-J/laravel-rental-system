 @extends("layouts.master")
@section("page")

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Customer Management</h4>
    <a href="{{url('customer/create')}}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1"></span> Create New Customer
    </a>
</div>

<x-card title="Customers">
<table class="table">
    <thead>
        <th>Id</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Address</th>
    </thead>
    @foreach($customers as $customer)
    <tbody>
    <tr>
    <td>{{$customer->id}}</td>
    <td>{{$customer->name}}</td>
    <td>{{$customer->mobile}}</td>
    <td>{{$customer->address}}</td>
    <td>
      <x-action view="customers/{{$customer->id}}" edit="customers/1/edit" delete="customers/1/delete"></x-action>

    <td>
    </tr>
    </tbody>
    @endforeach
    </table>
</x-card>
@endsection

<!-- <a href="{{url('customer/2/delete')}}">
    <x-button color="danger">Delete</x-button>
</a> -->