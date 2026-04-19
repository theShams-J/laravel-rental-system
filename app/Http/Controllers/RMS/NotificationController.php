<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Notification;

class NotificationController extends Controller
{
    public function markAllRead()
    {
        $user = Auth::user();

        if ($user) {
            Notification::forUser($user->id)
                ->unread()
                ->update([
                    'is_read' => 1,
                    'read_at' => now(),
                ]);
        }

        return redirect()->back();
    }
}
