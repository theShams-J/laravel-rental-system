<!-- parent pages-->
<a class="nav-link dropdown-indicator" href="#tenant" role="button" data-bs-toggle="collapse" aria-expanded="false"
  aria-controls="email">
  <div class="d-flex align-items-center"><span class="nav-link-icon"><span
        class="fas fa-user-tie"></span></span><span class="nav-link-text ps-1">Tenant</span>
  </div>
</a>
<ul class="nav collapse" id="tenant">
  <li class="nav-item"><a class="nav-link" href="{{url('tenants/create')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create Tenant</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
  <li class="nav-item"><a class="nav-link" href="{{url('tenants')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Manage Tenant</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
</ul>