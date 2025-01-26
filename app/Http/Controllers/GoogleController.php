<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Redirect ke Google untuk autentikasi
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan Google ID
            $user = User::where('google_id', $googleUser->id)->first();

            // Jika user tidak ada, buat user baru
            if (!$user) {
                $user = User::create([
                    'google_id' => $googleUser->id,
                    'username' => $googleUser->name,
                    'email' => $googleUser->email,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt('defaultpassword'), // Opsional, karena tidak digunakan
                ]);
            }

            // Login user
            Auth::login($user);

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
