<!-- parent pages-->
<a class="nav-link dropdown-indicator" href="#user" role="button" data-bs-toggle="collapse" aria-expanded="false"
  aria-controls="email">
  <div class="d-flex align-items-center"><span class="nav-link-icon"><span
        class="fas fa-users"></span></span><span class="nav-link-text ps-1">User</span>
  </div>
</a>
<ul class="nav collapse" id="user">
  <li class="nav-item"><a class="nav-link" href="{{url('users/create')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create User</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
  <li class="nav-item"><a class="nav-link" href="{{url('users')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Manage User</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
</ul>