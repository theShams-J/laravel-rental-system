@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Super Admin - Admin Users</h4>
    <a href="{{ route('super.admins.create') }}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1"></span> Create New Admin
    </a>
</div>

{{-- --- ALERT SECTION START --- --}}
@if(session('success'))
    <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">{{ session('success') }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
        <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1 fw-bold">{{ session('error') }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- --- ALERT SECTION END --- --}}

<x-card title="All Admin Users">
    <div class="table-responsive scrollbar">
        <table class="table table-hover table-striped align-middle">
            <thead class="bg-200 text-900">
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Last Login</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td class="text-center">
                        <div class="avatar avatar-sm">
                            @if($admin->photo)
                                <img class="rounded-circle" src="{{ asset('storage/' . $admin->photo) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" />
                            @else
                                <div class="avatar-name rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 12px; font-weight: bold; background-color: #1a6b4a; color: white;">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
                            @endif
                        </div>
                    </td>
                    <td class="fw-semi-bold text-nowrap">{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <span class="badge badge-soft-warning">
                            {{ $admin->company->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ $admin->last_login_at ? $admin->last_login_at->diffForHumans() : 'Never' }}</td>
                    <td class="text-center">
                        @if($admin->is_active)
                            <span class="badge badge-soft-success">Active</span>
                        @else
                            <span class="badge badge-soft-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <x-action
                            view="super/admins/{{ $admin->id }}"
                            edit="super/admins/{{ $admin->id }}/edit"
                            delete="super/admins/{{ $admin->id }}"
                        ></x-action>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="d-flex flex-column align-items-center">
                            <span class="fas fa-users fa-3x text-muted mb-3"></span>
                            <h6 class="text-muted">No admin users found</h6>
                            <a href="{{ route('super.admins.create') }}" class="btn btn-primary btn-sm">
                                <span class="fas fa-plus me-1"></span>Create First Admin
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admins->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $admins->links() }}
    </div>
    @endif
</x-card>
@endsection