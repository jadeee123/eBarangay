<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSettingsController extends Controller
{
    public function index()
{
    $settings = DB::table('staff_settings')
        ->where('user_id', auth()->id())
        ->first();

    $barangayInformation = DB::table('barangay_information')->first();

    return view('staff.settings', compact(
        'settings',
        'barangayInformation'
    ));
}

    public function updateProfile(Request $request)
    {
        $staff = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        DB::table('users')
            ->where('id', $staff->id)
            ->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('staff.settings')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $staff = auth()->user();

        if (!Hash::check($request->current_password, $staff->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        DB::table('users')
            ->where('id', $staff->id)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('staff.settings')
            ->with('success', 'Password changed successfully.');
    }

  public function updateNotifications(Request $request)
{
    $validated = $request->validate([
        'new_requests' => ['required', 'boolean'],
        'request_updates' => ['required', 'boolean'],
        'claim_schedule' => ['required', 'boolean'],
    ]);

    DB::table('staff_settings')->updateOrInsert(
        ['user_id' => $request->user()->id],
        [
            'new_requests' => $validated['new_requests'],
            'request_updates' => $validated['request_updates'],
            'claim_schedule' => $validated['claim_schedule'],
            'updated_at' => now(),
            'created_at' => now(),
        ]
    );

    return back()->with('success', 'Notification settings saved successfully.');
}

   public function updateBarangayInfo(Request $request)
{
    $validated = $request->validate([
        'barangay_name' => ['required', 'string', 'max:255'],
        'contact_email' => ['nullable', 'email', 'max:255'],
        'contact_number' => ['nullable', 'string', 'max:30'],
        'office_hours' => ['nullable', 'string', 'max:255'],
        'claim_instructions' => ['nullable', 'string', 'max:2000'],
    ]);

    $existing = DB::table('barangay_information')->first();

    if ($existing) {
        DB::table('barangay_information')
            ->where('id', $existing->id)
            ->update([
                ...$validated,
                'updated_at' => now(),
            ]);
    } else {
        DB::table('barangay_information')->insert([
            ...$validated,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return back()->with(
        'success',
        'Barangay information saved successfully.'
    );
}
}