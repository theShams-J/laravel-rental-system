@extends("layouts.master")
@section("page")
<x-card title="Terminate Lease - ID: {{ $lease->id }}">
    <div class="alert alert-danger">
        <h5>Are you sure you want to terminate this lease?</h5>
        <p>
            <strong>Tenant:</strong> {{ $lease->tenant->name }} <br>
            <strong>Apartment:</strong> {{ $lease->apartment->apartment_no }}
        </p>
        <p>This action will mark the apartment as <strong>Available</strong>.</p>
    </div>

    <div class="d-flex gap-2">
        <form action="{{ route('leases.destroy', $lease->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-button color="danger">Confirm Termination</x-button>
        </form>
        <a href="{{ route('leases.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</x-card>
@endsection