<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RMS\Company;
use App\Models\RMS\User;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'total_companies'  => Company::count(),
        'active_companies' => Company::where('is_active', 1)->count(),
        'inactive_companies' => Company::where('is_active', 0)->count(),
        'total_admins'     => User::where('role_id', 2)->count(),
        'active_admins'    => User::where('role_id', 2)->where('is_active', 1)->count(),
        'inactive_admins'  => User::where('role_id', 2)->where('is_active', 0)->count(),
    ];

    $companies = Company::withCount([
        'users as admins_count' => fn($q) => $q->where('role_id', 2),
    ])->latest()->get();

    $recentAdmins = User::with('company')
        ->where('role_id', 2)
        ->latest()
        ->limit(5)
        ->get();

    return view('super.dashboard.index', compact(
        'stats', 
        'companies', 
        'recentAdmins'
    ));
}
}
