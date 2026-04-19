<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\RMS\ApartmentController;
use App\Http\Controllers\RMS\BuildingController;
use App\Http\Controllers\RMS\LeaseController;
use App\Http\Controllers\RMS\FinanceController;
use App\Http\Controllers\RMS\InvoiceController;
use App\Http\Controllers\RMS\MoneyReceiptController;
use App\Http\Controllers\RMS\TenantController;
use App\Http\Controllers\RMS\TenantDashboardController;
use App\Http\Controllers\RMS\UserController;
use App\Http\Controllers\RMS\MaintenanceController;
use App\Http\Controllers\RMS\NotificationController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperDashboardController;
use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\AdminUserController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;


// ============================================================
// 1. PUBLIC ROUTES
// ============================================================
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ============================================================
// 2. TENANT PORTAL ROUTES
// ============================================================
Route::middleware(['tenant.auth'])->prefix('tenant')->name('tenant.')->group(function () {

    Route::get('/dashboard',                         [TenantDashboardController::class, 'index'])             ->name('dashboard');
    Route::get('/invoices',                          [TenantDashboardController::class, 'invoices'])          ->name('invoices');
    Route::get('/invoices/{id}',                     [TenantDashboardController::class, 'showInvoice'])       ->name('invoice.show');
    Route::get('/receipts',                          [TenantDashboardController::class, 'receipts'])          ->name('receipts');
    Route::get('/receipts/{id}',                     [TenantDashboardController::class, 'showReceipt'])       ->name('receipt.show');
    Route::get('/ledger',                            [TenantDashboardController::class, 'ledger'])            ->name('ledger');

    // Print routes (open in new tab)
    Route::get('/invoice/print/{id}',                [TenantDashboardController::class, 'printInvoice'])      ->name('invoice.print');
    Route::get('/receipt/print/{id}',                [TenantDashboardController::class, 'printReceipt'])      ->name('receipt.print');
    Route::get('/transactions/print/{tenantId}',     [TenantDashboardController::class, 'printTransactions']) ->name('transactions.print');

});


// ============================================================
// 3. SUPER ADMIN ROUTES
// ============================================================
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('super')
    ->name('super.')
    ->group(function () {

        Route::get('/dashboard', [SuperDashboardController::class, 'index'])->name('dashboard');

        Route::post('companies/{company}/toggle-active', [CompanyController::class, 'toggleActive'])
            ->name('companies.toggleActive');
        Route::get('companies/{id}/delete', [CompanyController::class, 'delete'])
            ->name('companies.delete');
        Route::resource('companies', CompanyController::class);

        Route::get('admins/{id}/delete', [AdminUserController::class, 'delete'])
            ->name('admins.delete');
        Route::resource('admins', AdminUserController::class);
        Route::post('superadmins/{superadmin}/toggle-active', [SuperAdminController::class, 'toggleActive'])
    ->name('superadmins.toggleActive');
Route::get('superadmins/{id}/delete', [SuperAdminController::class, 'delete'])
    ->name('superadmins.delete');
Route::resource('superadmins', SuperAdminController::class);


    });


// ============================================================
// 4. ADMIN ROUTES (company-scoped via CompanyScope)
// ============================================================
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ── Buildings ────────────────────────────────────────
    Route::get('buildings/{id}/delete', [BuildingController::class, 'delete'])->name('buildings.delete');
    Route::resource('buildings', BuildingController::class);

    // ── Apartments ───────────────────────────────────────
    Route::get('apartments/{id}/delete', [ApartmentController::class, 'delete'])->name('apartments.delete');
    Route::resource('apartments', ApartmentController::class);

    // ── Tenants ──────────────────────────────────────────
    Route::get('tenants/{id}/delete', [TenantController::class, 'delete'])->name('tenants.delete');
    Route::resource('tenants', TenantController::class);

    // ── Leases ───────────────────────────────────────────
    Route::get('leases/{id}/delete', [LeaseController::class, 'delete'])->name('leases.delete');
    Route::resource('leases', LeaseController::class);

    // ── Finance / Invoices / Receipts ────────────────────
    Route::post('/finance/record-payment/{invoice}', [FinanceController::class, 'recordPayment'])
        ->name('finance.record-payment');

    Route::get('invoices/{id}/delete', [InvoiceController::class, 'delete'])->name('invoices.delete');
    Route::resource('invoices', InvoiceController::class);

    Route::resource('receipts', MoneyReceiptController::class);

    // ── Users ────────────────────────────────────────────
    Route::resource('users', UserController::class);

    Route::get('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
        ->name('notifications.markAllRead');

    // ── Maintenance/Repairs ──────────────────────────────
    Route::get('maintenance/{id}/resolve', [MaintenanceController::class, 'resolveForm'])->name('maintenance.resolve.form');
    Route::post('maintenance/{id}/resolve', [MaintenanceController::class, 'resolve'])->name('maintenance.resolve');
    Route::get('maintenance/{id}/bill', [MaintenanceController::class, 'billForm'])->name('maintenance.bill.form');
    Route::post('maintenance/{id}/bill', [MaintenanceController::class, 'bill'])->name('maintenance.bill');
    Route::get('maintenance/{id}/delete', [MaintenanceController::class, 'delete'])->name('maintenance.delete');
    Route::resource('maintenance', MaintenanceController::class);

});