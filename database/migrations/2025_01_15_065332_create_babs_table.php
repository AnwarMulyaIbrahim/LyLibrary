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
        Schema::create('babs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id'); // Foreign key ke tabel books
            $table->integer('bab_number');
            $table->string('sub_title');
            $table->text('body');
            $table->timestamps();

            // Tambahkan foreign key
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('babs');
    }
};
