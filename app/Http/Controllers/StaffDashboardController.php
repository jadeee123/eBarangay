<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $totalRequests = DB::table('requests')->count();

        $pendingRequests = DB::table('requests')
            ->whereRaw('LOWER(status) = ?', ['pending'])
            ->count();

        $processingRequests = DB::table('requests')
            ->whereRaw('LOWER(status) = ?', ['processing'])
            ->count();

        $completedRequests = DB::table('requests')
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->count();

        $recentRequests = DB::table('requests')
            ->leftJoin('users', 'users.id', '=', 'requests.user_id')
            ->select('requests.*', 'users.name as resident_name')
            ->orderByDesc('requests.created_at')
            ->limit(5)
            ->get();

        $frequentServices = DB::table('requests')
            ->select(
                'service_name',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $maxServiceCount = $frequentServices->max('total') ?: 1;

        $frequentServices = $frequentServices->map(
            function ($service) use ($maxServiceCount) {
                $service->percentage = round(
                    ($service->total / $maxServiceCount) * 100
                );

                return $service;
            }
        );

        // Counts distinct residents represented in requests.
       
        // Count distinct residents by age group.
        // Use the age saved in the requests table.
        $age0to17 = DB::table('requests')
            ->whereNotNull('age')
            ->whereBetween('age', [0, 17])
            ->distinct()
            ->count('user_id');

        $age18to30 = DB::table('requests')
            ->whereBetween('age', [18, 30])
            ->distinct()
            ->count('user_id');

        $age31to59 = DB::table('requests')
            ->whereBetween('age', [31, 59])
            ->distinct()
            ->count('user_id');

        $age60Plus = DB::table('requests')
            ->where('age', '>=', 60)
            ->distinct()
            ->count('user_id');

            // Get unread contact messages for the notification bell
            $staffUnreadNotifications = DB::table('contact_messages')
            ->where('is_read', false)
            ->count();
            
            // Get the latest contact messages
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

        return view('staff.dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'processingRequests',
            'completedRequests',
            'recentRequests',
            'frequentServices',
           'age0to17',
           'age18to30',
           'age31to59',
           'age60Plus',
           'staffUnreadNotifications',
'staffNotifications',
        ));
    }
}
