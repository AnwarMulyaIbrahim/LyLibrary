<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index()
    {
        $books = Book::with('user')->get(); // Ambil semua buku beserta relasi user
        return response()->json($books, 200);
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string',
            'title' => 'required|string|max:255',
            'sinopsis' => 'required|string',
            'cover_book' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Simpan buku baru
        $book = Book::create($request->all());

        return response()->json([
            'message' => 'Book created successfully.',
            'book' => $book
        ], 201);
    }

    /**
     * Display the specified book.
     */
    public function show($id)
    {
        $book = Book::with('user')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        return response()->json($book, 200);
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'sinopsis' => 'nullable|string',
            'cover_book' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update buku
        $book->update($request->all());

        return response()->json([
            'message' => 'Book updated successfully.',
            'book' => $book
        ], 200);
    }

    /**
     * Remove the specified book.
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully.'], 200);
    }
}
