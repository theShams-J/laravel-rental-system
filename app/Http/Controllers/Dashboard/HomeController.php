<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RMS\Building;
use App\Models\RMS\Apartment;
use App\Models\RMS\Tenant;
use App\Models\RMS\MoneyReceipt;
use App\Models\RMS\Lease;
use App\Models\RMS\Maintenance;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Buildings with apartment count
        $buildings = Building::withCount('apartments')->get();

        // 2. Apartment Statistics
        $apartmentStats = [
            'total'     => Apartment::count(),
            'assigned'  => Apartment::where('status', 'Occupied')->count(),
            'available' => Apartment::where('status', 'Available')->count(),
        ];

        // 3. Total Tenants
        $tenantCount = Tenant::count();

        // 4. Total Collections
        $totalPayments = MoneyReceipt::sum('receipt_total') ?? 0;

        // 5. Recent Payments
        $recentPayments = MoneyReceipt::with(['tenant', 'lease.apartment.building'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 6. Pending Maintenance
        $pendingMaintenance = Maintenance::whereIn('status', ['Open', 'In Progress'])->get();

        $recentMaintenance = Maintenance::with(['apartment.building'])
            ->whereIn('status', ['Open', 'In Progress'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 7. Expiring Leases
        $expiringCount = Lease::where('status', 'Active')
            ->where('end_date', '<=', now()->addDays(30))
            ->count();

        return view('pages.Dashboard.index', compact(
            'buildings',
            'apartmentStats',
            'tenantCount',
            'totalPayments',
            'recentPayments',
            'pendingMaintenance',
            'recentMaintenance',
            'expiringCount'
        ));
    }
}