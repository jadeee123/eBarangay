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
    return Socialite::driver('google')
        ->setHttpClient(new \GuzzleHttp\Client([
            'verify' => 'C:/Users/User/Downloads/cacert.pem',
        ]))
        ->redirect();
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

        return redirect('/dashboard');
    }
}
