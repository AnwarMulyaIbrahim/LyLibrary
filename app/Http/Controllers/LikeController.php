<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Book;

class LikeController extends Controller
{
    /**
     * Menambahkan like ke buku.
     */
    public function likeBook(Request $request, $bookId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Cek apakah sudah di-like
        $existingLike = Like::where('user_id', $request->user_id)
            ->where('like_book_id', $bookId)
            ->first();

        if ($existingLike) {
            return response()->json(['message' => 'You have already liked this book'], 400);
        }

        // Tambahkan like
        Like::create([
            'user_id' => $request->user_id,
            'like_book_id' => $bookId,
        ]);

        return response()->json(['message' => 'Book liked successfully'], 201);
    }

    /**
     * Menghapus like dari buku.
     */
    public function unlikeBook(Request $request, $bookId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $like = Like::where('user_id', $request->user_id)
            ->where('like_book_id', $bookId)
            ->first();

        if (!$like) {
            return response()->json(['message' => 'Like not found'], 404);
        }

        $like->delete();

        return response()->json(['message' => 'Book unliked successfully'], 200);
    }

    /**
     * Mendapatkan daftar likes pada buku.
     */
    public function getLikes($bookId)
    {
        $likes = Like::where('like_book_id', $bookId)->get();

        return response()->json([
            'total_likes' => $likes->count(),
            'likes' => $likes,
        ], 200);
    }
}
