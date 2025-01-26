<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $fillable = ['library_book_id', 'user_id'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'library_book_id');
    }
}
