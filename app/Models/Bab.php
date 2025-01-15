<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bab extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'bab_number',
        'sub_title',
        'body',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
