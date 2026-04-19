<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RMS\Lease;
use App\Models\RMS\Invoice;
use App\Models\RMS\User;
use App\Models\RMS\Notification;
use Carbon\Carbon;

class CheckLeaseNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-lease-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expiring leases and overdue payments, notify admins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->checkExpiringLeases();
        $this->checkOverduePayments();
    }

    private function checkExpiringLeases()
    {
        $expiringSoon = Carbon::now()->addDays(30);

        $expiringLeases = Lease::where('end_date', '<=', $expiringSoon)
            ->where('end_date', '>=', Carbon::now())
            ->where('status', 'Active')
            ->with('tenant', 'apartment.building')
            ->get();

        foreach ($expiringLeases as $lease) {
            // Check if notification already sent for this lease
            $existing = Notification::where('company_id', $lease->company_id)
                ->where('type', 'lease_expiring')
                ->where('message', 'like', "%Lease expiring: {$lease->tenant->name}%")
                ->exists();

            if (!$existing) {
                $admins = User::where('company_id', $lease->company_id)
                    ->whereHas('role', function ($query) {
                        $query->where('name', 'admin');
                    })
                    ->get();

                foreach ($admins as $admin) {
                    Notification::create([
                        'company_id' => $lease->company_id,
                        'user_id' => $admin->id,
                        'type' => 'lease_expiring',
                        'message' => "Lease expiring: {$lease->tenant->name} - {$lease->apartment->apartment_no} ({$lease->end_date->format('M d, Y')})",
                        'url' => route('leases.index'), // assuming there's a leases route
                    ]);
                }
            }
        }
    }

    private function checkOverduePayments()
    {
        $overdueInvoices = Invoice::where('due_date', '<', Carbon::now())
            ->where('status', '!=', 'Paid')
            ->with('tenant', 'lease.apartment.building')
            ->get();

        foreach ($overdueInvoices as $invoice) {
            // Check if notification already sent for this invoice
            $existing = Notification::where('company_id', $invoice->company_id)
                ->where('type', 'payment_overdue')
                ->where('message', 'like', "%Overdue payment: {$invoice->tenant->name}%")
                ->exists();

            if (!$existing) {
                $admins = User::where('company_id', $invoice->company_id)
                    ->whereHas('role', function ($query) {
                        $query->where('name', 'admin');
                    })
                    ->get();

                foreach ($admins as $admin) {
                    Notification::create([
                        'company_id' => $invoice->company_id,
                        'user_id' => $admin->id,
                        'type' => 'payment_overdue',
                        'message' => "Overdue payment: {$invoice->tenant->name} - Invoice #{$invoice->id} (৳{$invoice->amount})",
                        'url' => route('invoices.index'), // assuming there's an invoices route
                    ]);
                }
            }
        }
    }
}
