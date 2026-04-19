{{-- Tenant Portal Sidebar Navigation --}}
{{-- Used inside layouts/tenant_layout.blade.php --}}

@php
    $tenantId   = session('tenant_id');
    $tenantData = $tenantId ? \App\Models\RMS\Tenant::withoutGlobalScopes()->find($tenantId) : null;
    $initials   = $tenantData ? strtoupper(substr($tenantData->name, 0, 1)) : 'T';
@endphp

{{-- Brand --}}
<a href="{{ route('tenant.dashboard') }}" class="t-brand">
    <img class="t-brand-logo"
         src="{{ asset('assets/img/icons/spot-illustrations/d.png') }}" alt="RMS">
    <span class="t-brand-name">R<span>M</span>S</span>
</a>

{{-- Tenant Info Card --}}
@if($tenantData)
<div class="t-user-card">
    <div class="t-user-label">Logged in as</div>
    <div class="t-user-name">{{ $tenantData->name }}</div>
    <div class="t-user-email">{{ $tenantData->email ?? $tenantData->contact }}</div>
</div>
@endif

{{-- Navigation --}}
<ul class="t-nav">
    <div class="t-nav-label">Menu</div>

    <li>
        <a href="{{ route('tenant.dashboard') }}"
           class="{{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
            <span class="t-nav-icon"><span class="fas fa-home"></span></span>
            My Dashboard
        </a>
    </li>

    <li>
        <a href="{{ route('tenant.dashboard') }}#invoices">
            <span class="t-nav-icon"><span class="fas fa-file-invoice"></span></span>
            My Invoices
        </a>
    </li>

    <li>
        <a href="{{ route('tenant.dashboard') }}#payments">
            <span class="t-nav-icon"><span class="fas fa-receipt"></span></span>
            Payment History
        </a>
    </li>

    <li>
        <a href="{{ route('tenant.dashboard') }}#ledger">
            <span class="t-nav-icon"><span class="fas fa-list-alt"></span></span>
            Transaction Ledger
        </a>
    </li>

    <li>
        <a href="{{ route('tenant.transactions.print', session('tenant_id')) }}" target="_blank">
            <span class="t-nav-icon"><span class="fas fa-print"></span></span>
            Print Transactions
        </a>
    </li>

</ul>

{{-- Logout --}}
<div class="t-sidebar-footer">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="t-logout">
            <span class="fas fa-sign-out-alt"></span> Logout
        </button>
    </form>
</div>
