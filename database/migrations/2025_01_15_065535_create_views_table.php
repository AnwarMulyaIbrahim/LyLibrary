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
        Schema::create('views', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('view_book_id'); // Foreign key ke tabel books
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key ke tabel users (opsional)
            $table->timestamps();

            // Tambahkan foreign key
            $table->foreign('view_book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('views');
    }
};
