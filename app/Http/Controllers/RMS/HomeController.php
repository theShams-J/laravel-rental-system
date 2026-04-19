<?php

// app/Http/Controllers/RMS/HomeController.php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use App\Models\RMS\Building;
use App\Models\RMS\Apartment;
use App\Models\RMS\Tenant;
use App\Models\RMS\Lease;
use App\Models\RMS\Invoice;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'total_buildings'  => Building::count(),
            'total_apartments' => Apartment::count(),
            'total_tenants'    => Tenant::count(),
            'active_leases'    => Lease::where('status', 'active')->count(),
            'unpaid_invoices'  => Invoice::where('status', 'unpaid')->count(),
        ];

        return view('rms.home', $data);
    }
}