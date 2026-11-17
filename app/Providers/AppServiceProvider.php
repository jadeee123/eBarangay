<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Staff notifications
        View::composer('layouts.dashstaff', function ($view) {
            if (auth()->check() && auth()->user()->role === 'staff') {
                $staffUnreadNotifications = DB::table('contact_messages')
                    ->where('is_read', false)
                    ->count();

                $staffNotifications = DB::table('contact_messages')
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get()
                    ->map(function ($message) {
                        $message->title = 'New Contact Message';
                        $message->full_message = $message->message;
                        $message->message = $message->subject . ' — ' . $message->name;

                        return $message;
                    });

                $view->with([
                    'staffUnreadNotifications' => $staffUnreadNotifications,
                    'staffNotifications' => $staffNotifications,
                ]);
            }
        });

        // Resident notifications
        View::composer('layouts.dashboard', function ($view) {
            if (auth()->check() && auth()->user()->role === 'resident') {
                $userId = auth()->id();

                $unreadNotifications = DB::table('resident_notifications')
                    ->where('user_id', $userId)
                    ->where('is_read', false)
                    ->count();

                $dashboardNotifications = DB::table('resident_notifications')
                    ->where('user_id', $userId)
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get();

                $view->with([
                    'unreadNotifications' => $unreadNotifications,
                    'dashboardNotifications' => $dashboardNotifications,
                ]);
            }
        });
    }
}
