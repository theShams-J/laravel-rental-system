@extends("layouts.master")
@section("page")

{{-- Background Illustration (Watermark) --}}
<div class="bg-illustration">
    <img src="{{ asset('assets/img/icons/spot-illustrations/d.png') }}" alt="Welcome Image">
    <h1 class="bg-text text-uppercase">Super Admin Overview</h1>
</div>

<div class="dashboard-container">
    <div class="container-fluid py-4 content-overlay">
        
        {{-- 1. Global Stats Blocks --}}
        <div class="row g-3 mb-4 text-dark">
            {{-- Companies Stats --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-primary border-4 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted fw-bold mb-2 small">Total Companies</h6>
                        <div class="d-flex justify-content-between align-items-end">
                            <h3 class="fw-bold mb-0">{{ $stats['total_companies'] }}</h3>
                            <span class="badge bg-soft-success text-success">{{ $stats['active_companies'] }} Active</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admins Stats --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-info border-4 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted fw-bold mb-2 small">System Admins</h6>
                        <div class="d-flex justify-content-between align-items-end">
                            <h3 class="fw-bold mb-0">{{ $stats['total_admins'] }}</h3>
                            <span class="text-muted extra-small">{{ $stats['active_admins'] }} Currently Active</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inactive Companies --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-success border-4 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted fw-bold mb-2 small">Inactive Companies</h6>
                        <div class="d-flex justify-content-between align-items-end">
                            <h3 class="fw-bold mb-0">{{ $stats['inactive_companies'] }}</h3>
                            <span class="text-muted extra-small">Dormant accounts</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inactive Admins --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-danger border-4 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted fw-bold mb-2 small">Inactive Admins</h6>
                        <div class="d-flex justify-content-between align-items-end">
                            <h3 class="fw-bold mb-0">{{ $stats['inactive_admins'] }}</h3>
                            <span class="text-muted extra-small">Awaiting activation</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- 2. Main Content Sections --}}
        <div class="row g-4">
            {{-- Left Column: Company Management --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Managed Companies</h5>
                        <a href="{{ route('super.companies.index') }}" class="btn btn-sm btn-primary rounded-pill">View All</a>
                    </div>
                    <div class="card-body px-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Admins</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                    <tr>
                                        <td class="fw-bold">{{ $company->name }}</td>
                                        <td><span class="badge bg-soft-info text-info">{{ $company->admins_count }}</span></td>
                                        <td>
                                            @if($company->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $company->created_at->format('M Y') }}</td>
                                        <td>
                                            <a href="{{ route('super.companies.edit', $company->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Recently Added Admins --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-transparent border-0 pt-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Recently Added Admins</h6>
                        <a href="{{ route('super.admins.index') }}"
                           class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($recentAdmins as $admin)
                            <li class="list-group-item border-light bg-transparent">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 small fw-bold">{{ $admin->name }}</p>
                                        <small class="text-muted extra-small">
                                            {{ $admin->company->name ?? '—' }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge {{ $admin->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $admin->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <br>
                                        <small class="text-muted extra-small">
                                            {{ $admin->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Base */
.dashboard-container { position: relative; min-height: 85vh; background: transparent; }
.bg-illustration {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;
    opacity: 0.15;
    text-align: center;
    width: 100%;
    pointer-events: none;
}

.bg-illustration img { width: 350px; filter: grayscale(100%) brightness(1.2); }
.bg-text { font-size: 2rem; font-weight: 900; color: #2c7be5; opacity: 0.3; letter-spacing: 10px; margin-top: 20px; }
.content-overlay { position: relative; z-index: 2; }

/* Stats Cards */
.floating-card { transition: all 0.3s ease; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(5px); }
.floating-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
.bg-soft-primary { background: rgba(44, 123, 229, 0.1); }
.bg-soft-info { background: rgba(39, 188, 253, 0.1); }
.bg-soft-success { background: rgba(0, 217, 126, 0.1); }
.extra-small { font-size: 0.72rem; }

/* Custom Scrollbar */
.building-scroll-list::-webkit-scrollbar { width: 4px; }
.building-scroll-list::-webkit-scrollbar-track { background: #f1f1f1; }
.building-scroll-list::-webkit-scrollbar-thumb { background: #2c7be5; border-radius: 10px; }

/* Dark mode overrides */
.dark .floating-card { background: rgba(42, 46, 50, 0.95); }
.dark .bg-text { color: #4a9eff; opacity: 0.4; }
.dark .building-scroll-list::-webkit-scrollbar-track { background: #2a2e32; }
.dark .building-scroll-list::-webkit-scrollbar-thumb { background: #4a9eff; }
</style>

@endsection