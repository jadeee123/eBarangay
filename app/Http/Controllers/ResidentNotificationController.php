<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ResidentNotificationController extends Controller
{
    public function index()
{
    $notifications = DB::table('resident_notifications')
        ->where('user_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

    $unreadCount = DB::table('resident_notifications')
        ->where('user_id', Auth::id())
        ->where('is_read', false)
        ->count();

    return view('resident-notifications', compact(
        'notifications',
        'unreadCount'
    ));
}

public function markAsRead($id)
{
    DB::table('resident_notifications')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->update([
            'is_read' => true,
            'updated_at' => now(),
        ]);

    return back()->with('success', 'Notification marked as read.');
}
}
