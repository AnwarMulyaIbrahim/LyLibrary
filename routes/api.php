<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BabController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\LibraryController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// login & register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


// Books

    Route::get('/books', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books/{id}', [BookController::class, 'show']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);



// Bab
    Route::get('/books/{book_id}/babs', [BabController::class, 'index']); // Semua bab dari sebuah buku
    Route::post('/babs', [BabController::class, 'store']); // Tambah bab baru
    Route::get('/babs/{id}', [BabController::class, 'show']); // Tampilkan bab tertentu
    Route::put('/babs/{id}', [BabController::class, 'update']); // Update bab
    Route::delete('/babs/{id}', [BabController::class, 'destroy']); // Hapus bab


// Follow
    Route::post('/follow', [FollowController::class, 'follow']); // Follow user
    Route::post('/unfollow', [FollowController::class, 'unfollow']); // Unfollow user
    Route::get('/users/{user_id}/following', [FollowController::class, 'following']); // List of following
    Route::get('/users/{user_id}/followers', [FollowController::class, 'followers']); // List of followers



// Likes
Route::post('/books/{bookId}/like', [LikeController::class, 'likeBook']);
Route::delete('/books/{bookId}/unlike', [LikeController::class, 'unlikeBook']);
Route::get('/books/{bookId}/likes', [LikeController::class, 'getLikes']);


// Views
Route::post('/books/{bookId}/view', [ViewController::class, 'addView']);
Route::get('/books/{bookId}/views', [ViewController::class, 'getViews']);



// Library
Route::post('/libraries/{bookId}/add', [LibraryController::class, 'addToLibrary']);
Route::post('/libraries/{bookId}/remove', [LibraryController::class, 'removeFromLibrary']);
Route::get('/libraries/{userId}', [LibraryController::class, 'getLibrary']);
