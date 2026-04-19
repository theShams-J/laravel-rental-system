<a class="nav-link dropdown-indicator" href="#maintenance"
   role="button" data-bs-toggle="collapse">
  <div class="d-flex align-items-center">
    <span class="nav-link-icon"><span class="fas fa-tools"></span></span>
    <span class="nav-link-text ps-1">Maintenance</span>
  </div>
</a>
<ul class="nav collapse" id="maintenance">
  <li class="nav-item">
    <a class="nav-link" href="{{ url('maintenance/create') }}">
      <span class="nav-link-text ps-1">Report Repair</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('maintenance') }}">
      <span class="nav-link-text ps-1">Manage Repairs</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('maintenance?status=Resolved') }}">
      <span class="nav-link-text ps-1">History</span>
    </a>
  </li>
</ul>
