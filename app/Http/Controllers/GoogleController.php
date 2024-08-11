<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        $googleUser = Socialite::driver('google')->user();
        $findUser = User::where('google_id', $googleUser->id)
                        ->where('email', $googleUser->email)
                        ->first();

        if ($findUser) {
            Auth::login($findUser);
            return redirect()->route('homepage');
        } else {
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => encrypt('123456dummy')
            ]);

            Auth::login($newUser);
            return redirect()->route('homepage');
        }

        return redirect()->intended('dashboard');

    }
}
