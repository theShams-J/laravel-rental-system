@extends("layouts.master")
@section("page")

{{-- Background Illustration (Watermark) --}}
    <div class="bg-illustration">
        <img src="{{ asset('assets/img/icons/spot-illustrations/d.png') }}" alt="Welcome Image">
        <h1 class="bg-text text-uppercase">Comfort - Elegance - Luxury</h1>
    </div>


<div class="dashboard-container">
    
    <div class="container-fluid py-4 content-overlay">
        
        {{-- 1. Floating Stats Blocks --}}
        <div class="row g-3 mb-4 text-dark">
            {{-- Buildings --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-primary border-4 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted fw-bold mb-2 small">Buildings</h6>
                        <div class="building-scroll-list" style="max-height: 80px; overflow-y: auto;">
                            @forelse($buildings as $building)
                                <div class="d-flex justify-content-between py-1 border-bottom border-light">
                                    <span class="small fw-bold">{{ $building->name }}</span>
                                    <span class="badge bg-soft-primary text-primary">{{ $building->apartments_count }}</span>
                                </div>
                            @empty
                                <span class="small text-muted">No buildings found</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Apartments --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-success border-4 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted fw-bold mb-3 small">Apartments</h6>
                        <div class="row text-center">
                            <div class="col-4">
                                <p class="mb-0 text-muted extra-small">Total</p>
                                <span class="fw-bold">{{ $apartmentStats['total'] ?? 0 }}</span>
                            </div>
                            <div class="col-4 border-start border-end">
                                <p class="mb-0 text-muted extra-small">Occ.</p>
                                <span class="fw-bold text-success">{{ $apartmentStats['assigned'] ?? 0 }}</span>
                            </div>
                            <div class="col-4">
                                <p class="mb-0 text-muted extra-small">Avail.</p>
                                <span class="fw-bold text-primary">{{ $apartmentStats['available'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tenants --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-info border-4 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-1 small">Tenants</h6>
                            <span class="h3 fw-bold mb-0">{{ $tenantCount ?? 0 }}</span>
                        </div>
                        <i class="fas fa-users fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>

            {{-- Total Collection --}}
            <div class="col-sm-6 col-md-3">
                <div class="card shadow-sm border-0 floating-card border-start border-warning border-4 h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold mb-1 small">Collected</h6>
                            <span class="h3 fw-bold mb-0">৳{{ number_format($totalPayments ?? 0, 0) }}</span>
                        </div>
                        <i class="fas fa-wallet fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- 2. Quick Action Buttons --}}
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ route('tenants.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                        <i class="fas fa-user-plus me-2"></i>New Tenant
                    </a>
                    <a href="{{ route('receipts.create') }}" class="btn btn-success shadow-sm rounded-pill px-4">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Collect Rent
                    </a>
                    <a href="#" class="btn btn-info shadow-sm rounded-pill px-4 text-white">
                        <i class="fas fa-chart-line me-2"></i>Reports
                    </a>
                </div>
            </div>
        </div>

        {{-- 3. Data Sections --}}
        <div class="row g-4">
            {{-- Left Column: Recent Payments --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="mb-0 fw-bold">Recent Collections</h5>
                    </div>
                    <div class="card-body px-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Tenant</th>
                                        <th>Building</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at->format('d M, Y') }}</td>
                                        <td>{{ $payment->tenant->name ?? 'N/A' }}</td>
                                        <td>{{ $payment->lease->apartment->building->name ?? 'N/A' }}</td>
                                        <td class="fw-bold">৳{{ number_format($payment->receipt_total, 0) }}</td>
                                        <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Alerts & Reminders --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4 border-top border-danger border-4 text-dark">
                    <div class="card-body">
                        <h6 class="text-uppercase text-danger fw-bold small mb-3">Attention Required</h6>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape bg-soft-danger text-danger rounded-circle me-3 px-3 py-2">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold small">{{ $pendingMaintenance->where('status','Open')->count() }} Open</h6>
                                <p class="text-muted extra-small mb-0">Unstarted repairs</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape bg-soft-warning text-warning rounded-circle me-3 px-3 py-2">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold small">{{ $pendingMaintenance->where('status','In Progress')->count() }} In Progress</h6>
                                <p class="text-muted extra-small mb-0">Ongoing repairs</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-soft-warning text-warning rounded-circle me-3 px-3 py-2">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold small">{{ $expiringCount }} Leases</h6>
                                <p class="text-muted extra-small mb-0">Expiring this month</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Occupancy Chart --}}
                <div class="card shadow-sm border-0 text-dark">
                    <div class="card-body text-center py-4">
                        <p class="text-muted small mb-1">Occupancy Rate</p>
                        <h3 class="fw-bold mb-0">
                            @php 
                                $rate = ($apartmentStats['total'] ?? 0) > 0 ? ($apartmentStats['assigned'] / $apartmentStats['total']) * 100 : 0;
                            @endphp
                            {{ round($rate, 1) }}%
                        </h3>
                        <div class="progress mt-3" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $rate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Pending Maintenance</h5>
                        <a href="{{ url('maintenance') }}" class="btn btn-sm btn-outline-danger rounded-pill">
                            View All
                        </a>
                    </div>
                    <div class="card-body px-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Apartment</th>
                                        <th>Building</th>
                                        <th>Issue</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Reported</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentMaintenance as $repair)
                                    <tr>
                                        <td>{{ $repair->apartment->apartment_no ?? 'N/A' }}</td>
                                        <td>{{ $repair->apartment->building->name ?? 'N/A' }}</td>
                                        <td class="fw-bold">{{ $repair->title }}</td>
                                        <td>
                                            @php
                                                $priorityClass = match($repair->priority) {
                                                    'Low'    => 'bg-secondary',
                                                    'Medium' => 'bg-info',
                                                    'High'   => 'bg-warning text-dark',
                                                    'Urgent' => 'bg-danger',
                                                    default  => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $priorityClass }}">{{ $repair->priority }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($repair->status) {
                                                    'Open'        => 'bg-soft-warning text-warning',
                                                    'In Progress' => 'bg-soft-info text-info',
                                                    default       => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ $repair->status }}</span>
                                        </td>
                                        <td>{{ $repair->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('maintenance/'.$repair->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No pending maintenance. All clear!
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Base */
.dashboard-container { position: relative; min-height: 85vh;  background: transparent; }
.bg-illustration {
    position: fixed;          /* ← key change */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;               /* ← behind everything */
    opacity: 0.2;
    text-align: center;
    width: 100%;
    pointer-events: none;
}

.bg-illustration img { width: 400px; }
.bg-text { font-size: 2.5rem; font-weight: 800; color: #2c7be5; letter-spacing: 5px; margin-top: 20px; }
.content-overlay { position: relative; z-index: 2; }

/* Cards & Stats */
.floating-card { transition: transform 0.3s ease; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
.floating-card:hover { transform: translateY(-5px); }
.bg-soft-primary { background: rgba(44, 123, 229, 0.1); }
.bg-soft-danger { background-color: rgba(230, 55, 87, 0.1); }
.bg-soft-warning { background-color: rgba(245, 128, 44, 0.1); }
.extra-small { font-size: 0.7rem; }

/* Tables */
.table-hover tbody tr:hover { background-color: #f8faff; }
.btn-primary { background-color: #2c7be5; border: none; }

/* Dark mode overrides */
.dark .floating-card { background: rgba(42, 46, 50, 0.9); }
.dark .bg-text { color: #4a9eff; }
.dark .table-hover tbody tr:hover { background-color: rgba(74, 158, 255, 0.1); }
.dark .btn-primary { background-color: #4a9eff; }
</style>

@endsection