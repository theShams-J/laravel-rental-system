<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Company;
use App\Models\RMS\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user->isSuperAdmin()) {
                    $authCompany = (object)[
                        'name' => 'RMS',
                        'logo' => null
                    ];
                } else {
                    $authCompany = Company::find($user->company_id);
                }

                $notifications = Notification::forUser($user->id)
                    ->latest()
                    ->limit(8)
                    ->get();

                $unreadNotificationCount = Notification::forUser($user->id)
                    ->unread()
                    ->count();
            } else {
                $authCompany = (object)[
                    'name' => 'RMS',
                    'logo' => null
                ];
                $notifications = collect();
                $unreadNotificationCount = 0;
            }

            $view->with('authCompany', $authCompany)
                ->with('notifications', $notifications)
                ->with('unreadNotificationCount', $unreadNotificationCount);
        });
    }
}