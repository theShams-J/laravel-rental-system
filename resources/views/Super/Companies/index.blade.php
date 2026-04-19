@extends("layouts.master")
@section("page")

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Company Management</h4>
    <a href="{{ route('super.companies.create') }}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1"></span> Create New Company
    </a>
</div>

<x-card title="Company Management">
    
    @if(session('success'))
        <div class="alert alert-success border-0 mt-3">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
            <tr>
                <td>
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded text-center" style="width: 40px; height: 40px; line-height: 40px;">
                            {{ substr($company->name, 0, 1) }}
                        </div>
                    @endif
                </td>
                <td>{{ $company->name }} <br> <small class="text-muted">BIN: {{ $company->bin }}</small></td>
                <td>{{ $company->email }}</td>
                <td>
                    <form action="{{ route('super.companies.toggleActive', $company->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm border-0 bg-transparent p-0">
                            <i class="fas {{ $company->is_active ? 'fa-toggle-on text-success' : 'fa-toggle-off text-danger' }} fa-lg"></i>
                        </button>
                    </form>
                </td>
                <td>
                    <x-action 
                        view="super/companies/{{ $company->id }}" 
                        edit="super/companies/{{ $company->id }}/edit" 
                        delete="super/companies/{{ $company->id }}/delete">
                    </x-action>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-3">
        {{ $companies->links() }}
    </div>
</x-card>
@endsection