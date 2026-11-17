<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register validate residents info before creating an acc.
    
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect('/dashboard');
}

    // Sign check if email and pass against db
   
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
    $request->session()->regenerate();

    if (Auth::user()->role === 'staff') {
        return redirect('/dashstaff');
    }

    return redirect('/dashboard');
}

    return back()->withErrors([
        'email' => 'The email or password is incorrect.',
    ])->onlyInput('email');
}

    // log out
    
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}

}
