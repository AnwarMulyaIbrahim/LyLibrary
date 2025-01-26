<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    /**
     * Follow a user.
     */
    public function follow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'followed_user_id' => 'required|exists:users,id|different:user_id',
        ]);

        // Cek apakah user sudah mengikuti pengguna yang dimaksud
        $exists = DB::table('follows')->where([
            ['user_id', '=', $request->user_id],
            ['followed_user_id', '=', $request->followed_user_id],
        ])->exists();

        if ($exists) {
            return response()->json(['message' => 'You are already following this user.'], 400);
        }

        // Tambahkan data ke tabel follows
        DB::table('follows')->insert([
            'user_id' => $request->user_id,
            'followed_user_id' => $request->followed_user_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Successfully followed the user.'], 201);
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'followed_user_id' => 'required|exists:users,id',
        ]);

        // Hapus data follow dari tabel
        $deleted = DB::table('follows')->where([
            ['user_id', '=', $request->user_id],
            ['followed_user_id', '=', $request->followed_user_id],
        ])->delete();

        if (!$deleted) {
            return response()->json(['message' => 'You are not following this user.'], 400);
        }

        return response()->json(['message' => 'Successfully unfollowed the user.'], 200);
    }

    /**
     * Get the list of users a user is following.
     */
    public function following($user_id)
    {
        $following = DB::table('follows')
            ->where('user_id', $user_id)
            ->join('users', 'follows.followed_user_id', '=', 'users.id')
            ->select('users.id', 'users.username', 'users.avatar')
            ->get();

        return response()->json($following, 200);
    }

    /**
     * Get the list of followers for a user.
     */
    public function followers($user_id)
    {
        $followers = DB::table('follows')
            ->where('followed_user_id', $user_id)
            ->join('users', 'follows.user_id', '=', 'users.id')
            ->select('users.id', 'users.username', 'users.avatar')
            ->get();

        return response()->json($followers, 200);
    }
}
