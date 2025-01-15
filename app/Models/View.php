<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'view_book_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
