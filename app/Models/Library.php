<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'library_book_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
