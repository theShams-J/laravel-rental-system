<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
  <script>
    var navbarStyle = localStorage.getItem("navbarStyle");
    if (navbarStyle && navbarStyle !== 'transparent') {
      document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
    }
  </script>
  
  <div class="d-flex align-items-center">
    <div class="toggle-icon-wrapper">
      <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
        data-bs-placement="left" title="Toggle Navigation">
        <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
      </button>
    </div>
    <a class="navbar-brand" href="{{ url('/home') }}">
      <div class="d-flex align-items-center py-3">
        <img 
    class="me-2" 
    src="{{ $authCompany?->logo ? asset('storage/' . $authCompany->logo) : asset('assets/img/icons/spot-illustrations/d.png') }}"
    alt="{{ $authCompany?->name ?? 'RMS' }}" 
    width="40" 
    style="object-fit: contain;"
          />
        <span class="font-sans-serif" style="color: green;">RMS</span>
      </div>
    </a>
  </div>

  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content scrollbar">
      <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
       {{-- Super Admin Menu — always first --}}
@include("menus.superadmin")

{{-- Admin Menus — hide from super admin --}}
@if(Auth::check() && !Auth::user()->isSuperAdmin())
    @include("menus.dashboard")
    @include("menus.tenant")
    @include("menus.apartment")
    @include("menus.maintenance")
    @include("menus.invoice")
    @include("menus.rent")
    @include("menus.building")
    @include("menus.user")
    

    <li class="nav-item">
        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">ERP</div>
            <div class="col ps-0">
                <hr class="mb-0 navbar-vertical-divider" />
            </div>
        </div>
    </li>
@endif

        {{-- 2. TENANT MENU SECTION (Shows only if Tenant session exists AND not Admin) --}}
        @if(session()->has('tenant_id') && !Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tenant.dashboard') }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon"><span class="fas fa-home"></span></span>
                        <span class="nav-link-text ps-1">My Dashboard</span>
                    </div>
                </a>
            </li>
        @endif

      </ul>

      {{-- 3. PURCHASE SETTINGS (Admin Only) --}}
      @if(Auth::check())
      <div class="settings mb-3">
        <div class="card shadow-none">
          <div class="card-body alert mb-0" role="alert">
            <div class="btn-close-falcon-container">
              <button class="btn btn-link btn-close-falcon p-0" aria-label="Close" data-bs-dismiss="alert"></button>
            </div>
            <div class="text-center">
              <img src="{{asset('assets/img/icons/spot-illustrations/navbar-vertical.png')}}" alt="" width="80" />
              <p class="fs--2 mt-2">Loving what you see? <br />Get your copy of <a href="#!">Intellect</a></p>
              <div class="d-grid">
                <a class="btn btn-sm btn-purchase" href="https://themes.getbootstrap.com/product/falcon-admin-dashboard-webapp-template/" target="_blank">Purchase</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

    </div>
  </div>
</nav>