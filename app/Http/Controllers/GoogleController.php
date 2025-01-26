<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Response;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google callback and return the user data via API.
     */
    public function handleGoogleCallback()
{
    try {
        // Gunakan stateless mode
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Log user data dari Google
        Log::info('Google User Data: ', [
            'id' => $googleUser->getId(),
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),

        ]);

        // Buat atau dapatkan user di database
        $user = User::firstOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),

            ]
        );

        Log::info('User saved to database: ', $user->toArray());

        $token = $user->createToken('GoogleLogin')->plainTextToken;

        return response()->json([
            'message' => 'Login successful via Google',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Google login error: ' . $e->getMessage());

        return response()->json([
            'message' => 'Error logging in with Google',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}
