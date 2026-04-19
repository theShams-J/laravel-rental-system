<!-- parent pages-->
<a class="nav-link dropdown-indicator" href="#apartment" role="button" data-bs-toggle="collapse" aria-expanded="false"
  aria-controls="email">
  <div class="d-flex align-items-center"><span class="nav-link-icon"><span
        class="fas fa-home"></span></span><span class="nav-link-text ps-1">Apartment</span>
  </div>
</a>
<ul class="nav collapse" id="apartment">
  <li class="nav-item"><a class="nav-link" href="{{url('apartments/create')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create Apartment</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
  <li class="nav-item"><a class="nav-link" href="{{url('apartments')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Manage Apartment</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
</ul>