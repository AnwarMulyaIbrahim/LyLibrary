<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('library_book_id'); // Foreign key ke tabel books
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->timestamps();

            // Tambahkan foreign key
            $table->foreign('library_book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Hindari duplikasi (user hanya dapat menambahkan satu buku tertentu ke library mereka sekali)
            $table->unique(['library_book_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
