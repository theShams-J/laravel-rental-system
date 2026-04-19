@extends("layouts.master")

@section("page")
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Super Admin Management</h4>
    <a href="{{ route('super.superadmins.create') }}" class="btn btn-primary btn-sm">
        <span class="fas fa-plus me-1"></span> Create New Super Admin
    </a>
</div>

<x-card title="All Super Admins">
    <div class="table-responsive scrollbar">
        <table class="table table-hover table-striped align-middle">
            <thead class="bg-200 text-900">
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th class="text-center">Status</th>
                    <th>Last Login</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($superAdmins as $sa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="avatar avatar-sm">
                            @if($sa->photo)
                                <img class="rounded-circle" src="{{ asset('storage/' . $sa->photo) }}" alt="{{ $sa->name }}" style="width: 40px; height: 40px; object-fit: cover;" />
                            @else
                                <div class="avatar-name rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 12px; font-weight: 700; background-color: #1a6b4a; color: #fff;">
                                    {{ strtoupper(substr($sa->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="fw-semi-bold text-nowrap">
                        {{ $sa->name }}
                        @if($sa->id === auth()->id())
                            <span class="badge badge-soft-primary ms-1">You</span>
                        @endif
                    </td>
                    <td>{{ $sa->email }}</td>
                    <td>{{ $sa->contact ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge rounded-pill {{ $sa->is_active ? 'badge-soft-success' : 'badge-soft-secondary' }}">
                            {{ $sa->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        {{ $sa->last_login_at ? $sa->last_login_at->diffForHumans() : '—' }}
                    </td>
                    <td class="text-end">
                        <x-action
                            view="super/superadmins/{{ $sa->id }}"
                            edit="super/superadmins/{{ $sa->id }}/edit"
                            delete="super/superadmins/{{ $sa->id }}/delete"
                        />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No super admins found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-center">
        {{ $superAdmins->links() }}
    </div>
</x-card>
@endsection