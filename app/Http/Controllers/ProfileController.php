<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        Auth::user()->update([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('profile', ['panel' => 'account'])
            ->with('account_success', 'Account details updated successfully!');
    }
}