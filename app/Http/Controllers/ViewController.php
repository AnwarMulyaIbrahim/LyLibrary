<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\View;

class ViewController extends Controller
{
    /**
     * Menambahkan view ke buku.
     */
    public function addView(Request $request, $bookId)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id', // Bisa null jika tidak ada user
        ]);

        View::create([
            'view_book_id' => $bookId,
            'user_id' => $request->user_id, // Bisa null
        ]);

        return response()->json(['message' => 'View added successfully'], 201);
    }

    /**
     * Mendapatkan jumlah view untuk buku tertentu.
     */
    public function getViews($bookId)
    {
        $totalViews = View::where('view_book_id', $bookId)->count();

        return response()->json([
            'book_id' => $bookId,
            'total_views' => $totalViews,
        ], 200);
    }
}
