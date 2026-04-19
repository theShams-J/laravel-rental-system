<!-- parent pages-->
<a class="nav-link dropdown-indicator" href="#rent" role="button" data-bs-toggle="collapse" aria-expanded="false"
  aria-controls="email">
  <div class="d-flex align-items-center"><span class="nav-link-icon"><span
        class="fas fa-file-contract"></span></span><span class="nav-link-text ps-1">Rent</span>
  </div>
</a>
<ul class="nav collapse" id="rent">
  <li class="nav-item"><a class="nav-link" href="{{url('leases/create')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create Rent</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
  <li class="nav-item"><a class="nav-link" href="{{url('leases')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Manage Rent</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
</ul>