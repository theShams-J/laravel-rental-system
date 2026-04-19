@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">User Management</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1"></span> Create New User
    </a>
</div>

<x-card title="All Users">
    <div class="table-responsive scrollbar">
        <table class="table table-hover table-striped align-middle">
            <thead class="bg-200 text-900">
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                  
                    <th class="text-center">Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-center">
                        <div class="avatar avatar-sm">
                            @if($user->photo)
                                <img class="rounded-circle" src="{{ asset('storage/' . $user->photo) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" />
                            @else
                                <div class="avatar-name rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 12px; font-weight: bold; background-color: #1a6b4a; color: white;">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="fw-semi-bold text-nowrap">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-soft-info">
                            {{ ucfirst(str_replace('_', ' ', $user->role->name ?? 'N/A')) }}
                        </span>
                    </td>
                    <td>
                        @if($user->tenant)
                            <span class="text-primary fs--1">
                                <i class="fas fa-link me-1"></i>{{ $user->tenant->name }}
                            </span>
                        @else
                            <span class="text-400 fs--1">System Staff</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge rounded-pill {{ $user->is_active ? 'badge-soft-success' : 'badge-soft-secondary' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <x-action
                            view="users/{{ $user->id }}"
                            edit="users/{{ $user->id }}/edit"
                            delete="users/{{ $user->id }}"
                        />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</x-card>
@endsection