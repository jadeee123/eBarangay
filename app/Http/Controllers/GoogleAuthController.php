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
    return Socialite::driver('google')->redirect();
}


public function callback()
{
    $sessionState = request()->session()->get('state');
    $callbackState = request()->query('state');

    \Illuminate\Support\Facades\Log::info('Google OAuth state check', [
        'session_state_exists' => is_string($sessionState),
        'callback_state_exists' => is_string($callbackState),
        'states_match' => is_string($sessionState)
            && is_string($callbackState)
            && hash_equals($sessionState, $callbackState),
    ]);

    $googleUser = Socialite::driver('google')->user();

        
        Auth::login($user);
        
        request()->session()->regenerate();
        
        if ($user->role === 'staff') {
            return redirect('/dashstaff');
            }
            
            return redirect('/dashboard');
    }
}
