{{-- Super Admin Menu — only visible to super_admin role --}}
@if(Auth::check() && Auth::user()->isSuperAdmin())

{{-- Section Label --}}
<li class="nav-item">
    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
        <div class="col-auto navbar-vertical-label">Super Admin</div>
        <div class="col ps-0">
            <hr class="mb-0 navbar-vertical-divider" />
        </div>
    </div>
</li>

{{-- Super Dashboard --}}
<li class="nav-item">
    <a class="nav-link dropdown-indicator" href="#super-dashboard" role="button"
        data-bs-toggle="collapse" aria-expanded="false" aria-controls="super-dashboard">
        <div class="d-flex align-items-center">
            <span class="nav-link-icon"><span class="fas fa-tachometer-alt"></span></span>
            <span class="nav-link-text ps-1">Super Dashboard</span>
        </div>
    </a>
    <ul class="nav collapse" id="super-dashboard">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super.dashboard') }}">
                <div class="d-flex align-items-center">
                    <span class="nav-link-text ps-1">Overview</span>
                </div>
            </a>
        </li>
    </ul>
</li>

{{-- Companies --}}
<li class="nav-item">
    <a class="nav-link dropdown-indicator" href="#super-companies" role="button"
        data-bs-toggle="collapse" aria-expanded="false" aria-controls="super-companies">
        <div class="d-flex align-items-center">
            <span class="nav-link-icon"><span class="fas fa-building"></span></span>
            <span class="nav-link-text ps-1">Companies</span>
        </div>
    </a>
    <ul class="nav collapse" id="super-companies">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super.companies.create') }}">
                <div class="d-flex align-items-center">
                    <span class="nav-link-text ps-1">Create Company</span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super.companies.index') }}">
                <div class="d-flex align-items-center">
                    <span class="nav-link-text ps-1">Manage Companies</span>
                </div>
            </a>
        </li>
    </ul>
</li>

{{-- Admin Users --}}
<li class="nav-item">
    <a class="nav-link dropdown-indicator" href="#super-admins" role="button"
        data-bs-toggle="collapse" aria-expanded="false" aria-controls="super-admins">
        <div class="d-flex align-items-center">
            <span class="nav-link-icon"><span class="fas fa-user-shield"></span></span>
            <span class="nav-link-text ps-1">Admin Users</span>
        </div>
    </a>
    <ul class="nav collapse" id="super-admins">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super.admins.create') }}">
                <div class="d-flex align-items-center">
                    <span class="nav-link-text ps-1">Create Admin</span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super.admins.index') }}">
                <div class="d-flex align-items-center">
                    <span class="nav-link-text ps-1">Manage Admins</span>
                </div>
            </a>
        </li>
    </ul>
</li>

{{-- Super Admins --}}
<li class="nav-item">
    <a class="nav-link dropdown-indicator" href="#super-superadmins" role="button"
        data-bs-toggle="collapse" aria-expanded="false" aria-controls="super-superadmins">
        <div class="d-flex align-items-center">
            <span class="nav-link-icon"><span class="fas fa-user-cog"></span></span>
            <span class="nav-link-text ps-1">Super Admins</span>
        </div>
    </a>
    <ul class="nav collapse" id="super-superadmins">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super.superadmins.create') }}">
                <div class="d-flex align-items-center">
                    <span class="nav-link-text ps-1">Create Super Admin</span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('super.superadmins.index') }}">
                <div class="d-flex align-items-center">
                    <span class="nav-link-text ps-1">Manage Super Admins</span>
                </div>
            </a>
        </li>
    </ul>
</li>

@endif