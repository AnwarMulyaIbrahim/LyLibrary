<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
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

    // Log the google user data
    Log::info($googleUser);

    $user = User::firstOrCreate([
        'google_id' => $googleUser->getId(),
    ], [
        'name' => $googleUser->getName(),
        'email' => $googleUser->getEmail(),
        'avatar' => $googleUser->getAvatar(),
    ]);

    Auth::login($user);

    return redirect()->route('home');
}

}
