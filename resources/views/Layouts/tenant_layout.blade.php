<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Portal | RMS</title>
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --emerald:      #1a6b4a;
            --emerald-dark: #155a3d;
            --emerald-pale: #edf7f2;
            --gold:         #c49a2a;
            --border:       #e8eaef;
            --ink:          #16191f;
            --ink-soft:     #4a5160;
            --ink-muted:    #8c93a3;
            --surface:      #f7f8fa;
            --white:        #ffffff;
        }
        
        /* Dark mode overrides */
        .dark {
            --emerald:      #2d8a63;
            --emerald-dark: #1a5a42;
            --emerald-pale: #1a3a2e;
            --gold:         #d4a52f;
            --border:       #3a3f44;
            --ink:          #e8eaed;
            --ink-soft:     #b0b3b8;
            --ink-muted:    #8c9196;
            --surface:      #1a1d20;
            --white:        #2a2e32;
        }

        /* ── LAYOUT SHELL ── */
        body { margin: 0; font-family: 'DM Sans', sans-serif; background: var(--surface); }

        .tenant-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .tenant-sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--white);
            border-right: 1px solid rgba(26,107,74,0.10);
            box-shadow: 2px 0 24px rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        /* Brand */
        .t-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 18px 18px;
            border-bottom: 1px solid rgba(26,107,74,0.08);
            text-decoration: none;
        }

        .t-brand-logo {
            width: 34px; height: 34px;
            border-radius: 8px;
            object-fit: contain;
            border: 1.5px solid rgba(26,107,74,0.2);
            padding: 3px;
            background: var(--emerald-pale);
        }

        .t-brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 19px;
            font-weight: 600;
            letter-spacing: 3px;
            color: var(--emerald);
            text-transform: uppercase;
        }

        .t-brand-name span { color: var(--gold); }

        /* Tenant info card */
        .t-user-card {
            margin: 14px 12px;
            background: var(--emerald-pale);
            border: 1px solid rgba(26,107,74,0.15);
            border-radius: 10px;
            padding: 14px;
        }

        .t-user-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--emerald);
            margin-bottom: 5px;
        }

        .t-user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 2px;
        }

        .t-user-email {
            font-size: 11.5px;
            color: var(--ink-muted);
            word-break: break-all;
        }

        /* Nav menu */
        .t-nav {
            list-style: none;
            padding: 10px 12px;
            margin: 0;
            flex: 1;
        }

        .t-nav-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--ink-muted);
            padding: 10px 8px 6px;
        }

        .t-nav li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 400;
            color: var(--ink-soft);
            text-decoration: none;
            transition: all 0.18s;
            margin-bottom: 2px;
        }

        .t-nav li a:hover {
            background: var(--emerald-pale);
            color: var(--emerald);
        }

        .t-nav li a.active {
            background: var(--emerald-pale);
            color: var(--emerald);
            font-weight: 500;
        }

        .t-nav li a .t-nav-icon {
            width: 28px; height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 13px;
            color: var(--ink-muted);
            transition: all 0.18s;
            flex-shrink: 0;
        }

        .t-nav li a:hover .t-nav-icon,
        .t-nav li a.active .t-nav-icon {
            background: rgba(26,107,74,0.12);
            color: var(--emerald);
        }

        /* Logout at bottom */
        .t-sidebar-footer {
            padding: 12px;
            border-top: 1px solid var(--border);
        }

        .t-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #c0392b;
            text-decoration: none;
            transition: all 0.18s;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
        }

        .t-logout:hover {
            background: #fdf0ee;
        }

        /* ── TOPBAR ── */
        .tenant-topbar {
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            height: 60px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(26,107,74,0.10);
            z-index: 99;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .topbar-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-tenant-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--emerald-pale);
            border: 1px solid rgba(26,107,74,0.2);
            border-radius: 20px;
            padding: 5px 14px 5px 8px;
        }

        .topbar-avatar {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: var(--emerald);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .topbar-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--emerald);
        }

        /* ── MAIN CONTENT ── */
        .tenant-main {
            margin-left: 240px;
            padding-top: 60px;
            min-height: 100vh;
            flex: 1;
        }

        .tenant-content {
            padding: 0;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .tenant-sidebar { display: none; }
            .tenant-topbar  { left: 0; }
            .tenant-main    { margin-left: 0; }
        }
    </style>
</head>
<body>

@php
    $tenantId   = session('tenant_id');
    $tenantData = $tenantId ? \App\Models\RMS\Tenant::find($tenantId) : null;
    $initials   = $tenantData ? strtoupper(substr($tenantData->name, 0, 1)) : 'T';
@endphp

<div class="tenant-shell">

    {{-- ── SIDEBAR ── --}}
    <div class="tenant-sidebar">

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
            <div class="t-user-email">{{ $tenantData->email ?? $tenantData->mobile }}</div>
        </div>
        @endif

        {{-- Navigation --}}
<ul class="t-nav">
    <div class="t-nav-label">Menu</div>

    <li>
        <a href="{{ route('tenant.dashboard') }}"
           class="{{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
            <span class="t-nav-icon"><span class="fas fa-home"></span></span>
            Dashboard
        </a>
    </li>

    <li>
        <a href="{{ route('tenant.invoices') }}"
           class="{{ request()->routeIs('tenant.invoices*') ? 'active' : '' }}">
            <span class="t-nav-icon"><span class="fas fa-file-invoice"></span></span>
            My Invoices
        </a>
    </li>

    <li>
        <a href="{{ route('tenant.receipts') }}"
           class="{{ request()->routeIs('tenant.receipts*') ? 'active' : '' }}">
            <span class="t-nav-icon"><span class="fas fa-receipt"></span></span>
            Money Receipts
        </a>
    </li>

    @if($tenantId)
    <li>
        <a href="{{ route('tenant.transactions.print', $tenantId) }}" target="_blank">
            <span class="t-nav-icon"><span class="fas fa-print"></span></span>
            Transaction Ledger
        </a>
    </li>
    @endif

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

    </div>

    {{-- ── MAIN ── --}}
    <div class="tenant-main">

        {{-- Topbar --}}
        <div class="tenant-topbar">
            <div class="topbar-title">Tenant Portal</div>
            <div class="topbar-right">
                @if($tenantData)
                <div class="topbar-tenant-pill">
                    <div class="topbar-avatar">{{ $initials }}</div>
                    <span class="topbar-name">{{ $tenantData->name }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Page Content --}}
        <div class="tenant-content">
            @yield('page')
        </div>

    </div>

</div>

<script>
    // Ensure theme is applied on every page load
    var theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    
    // Handle theme switching
    document.addEventListener('DOMContentLoaded', function() {
        var themeRadios = document.querySelectorAll('input[name="theme-color"]');
        themeRadios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                var theme = this.value;
                localStorage.setItem('theme', theme);
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            });
        });
        
        // Handle reset button
        var resetBtn = document.querySelector('[data-theme-control="reset"]');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                localStorage.setItem('theme', 'light');
                document.documentElement.classList.remove('dark');
                var lightRadio = document.getElementById('themeSwitcherLight');
                if (lightRadio) {
                    lightRadio.checked = true;
                }
            });
        }
    });
</script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>