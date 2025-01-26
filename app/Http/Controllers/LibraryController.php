<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;

class LibraryController extends Controller
{
    /**
     * Tambahkan buku ke library pengguna.
     */
    public function addToLibrary(Request $request, $bookId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $library = Library::create([
            'library_book_id' => $bookId,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Book added to library successfully',
            'data' => $library,
        ], 201);
    }

    /**
     * Hapus buku dari library pengguna.
     */
    public function removeFromLibrary(Request $request, $bookId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        Library::where('library_book_id', $bookId)
            ->where('user_id', $request->user_id)
            ->delete();

        return response()->json([
            'message' => 'Book removed from library successfully',
        ], 200);
    }

    /**
     * Dapatkan daftar buku di library pengguna.
     */
    public function getLibrary($userId)
    {
        $library = Library::where('user_id', $userId)->with('book')->get();

        return response()->json([
            'message' => 'Library fetched successfully',
            'data' => $library,
        ], 200);
    }
}
