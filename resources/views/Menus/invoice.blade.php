<!-- parent pages-->
<a class="nav-link dropdown-indicator" href="#invoice" role="button" data-bs-toggle="collapse" aria-expanded="false"
  aria-controls="email">
  <div class="d-flex align-items-center"><span class="nav-link-icon"><span
        class="fas fa-coins"></span></span><span class="nav-link-text ps-1">Accounts</span>
  </div>
</a>
<ul class="nav collapse" id="invoice">
  <li class="nav-item"><a class="nav-link" href="{{url('invoices/create')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create Invoice</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
  <li class="nav-item"><a class="nav-link" href="{{url('invoices')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Manage Invoice</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
  <li class="nav-item"><a class="nav-link" href="{{url('receipts/create')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create Receipt</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
  <li class="nav-item"><a class="nav-link" href="{{url('receipts')}}">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Manage Receipt</span>
      </div>
    </a>
    <!-- more inner pages-->
  </li>
</ul>