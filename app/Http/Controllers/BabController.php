<?php

namespace App\Http\Controllers;

use App\Models\Bab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BabController extends Controller
{
    /**
     * Display a listing of chapters for a specific book.
     */
    public function index($book_id)
    {
        $babs = Bab::where('book_id', $book_id)->get();

        if ($babs->isEmpty()) {
            return response()->json(['message' => 'No chapters found for this book.'], 404);
        }

        return response()->json($babs, 200);
    }

    /**
     * Store a newly created chapter.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'bab_number' => 'required|integer',
            'sub_title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Simpan bab baru
        $bab = Bab::create($request->all());

        return response()->json([
            'message' => 'Chapter created successfully.',
            'bab' => $bab
        ], 201);
    }

    /**
     * Display the specified chapter.
     */
    public function show($id)
    {
        $bab = Bab::find($id);

        if (!$bab) {
            return response()->json(['message' => 'Chapter not found.'], 404);
        }

        return response()->json($bab, 200);
    }

    /**
     * Update the specified chapter.
     */
    public function update(Request $request, $id)
    {
        $bab = Bab::find($id);

        if (!$bab) {
            return response()->json(['message' => 'Chapter not found.'], 404);
        }

        // Validasi data
        $validator = Validator::make($request->all(), [
            'bab_number' => 'nullable|integer',
            'sub_title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update bab
        $bab->update($request->all());

        return response()->json([
            'message' => 'Chapter updated successfully.',
            'bab' => $bab
        ], 200);
    }

    /**
     * Remove the specified chapter.
     */
    public function destroy($id)
    {
        $bab = Bab::find($id);

        if (!$bab) {
            return response()->json(['message' => 'Chapter not found.'], 404);
        }

        $bab->delete();

        return response()->json(['message' => 'Chapter deleted successfully.'], 200);
    }
}
