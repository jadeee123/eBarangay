<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationSettingsController extends Controller
{
    public function show()
{
    $notificationSettings = DB::table('notification_settings')
        ->where('user_id', Auth::id())
        ->first();

    return view('profile', compact('notificationSettings'));
}

    public function update(Request $request)
    {
        $preferences = [
            'request_updates' => $request->boolean('request_updates'),
            'claim_reminders' => $request->boolean('claim_reminders'),
            'account_notifications' => $request->boolean('account_notifications'),
        ];

        DB::table('notification_settings')->updateOrInsert(
            ['user_id' => Auth::id()],
            array_merge($preferences, [
                'updated_at' => now(),
                'created_at' => now(),
            ])
        );

        return redirect()->route('profile', ['panel' => 'notifications'])
        ->with('notification_success', 'Notification settings saved successfully!');
    }
}