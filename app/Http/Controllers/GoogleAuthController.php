<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
 public function redirect()
{
    $response = Socialite::driver('google')->redirect();

    logger()->info('Google redirect state check', [
        'state_exists' => is_string(session()->get('state')),
    ]);

    return $response;
}

public function callback()
{
    $googleUser = Socialite::driver('google')->user();

    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        $user = User::create([
            'name' => $googleUser->getName() ?? 'Google User',
            'email' => $googleUser->getEmail(),
            'password' => bcrypt(Str::random(32)),
        ]);
    }

    Auth::login($user);

    request()->session()->regenerate();

    if ($user->role === 'staff') {
        return redirect('/dashstaff');
    }

    return redirect('/dashboard');
}
}