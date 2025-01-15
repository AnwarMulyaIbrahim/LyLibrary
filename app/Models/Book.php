<?php

namespace App\Models;

use App\Models\Bab;
use App\Models\Like;
use App\Models\User;
use App\Models\View;
use App\Models\Library;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'title',
        'sinopsis',
        'cover_book',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function babs()
    {
        return $this->hasMany(Bab::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function librarys()
    {
        return $this->hasMany(Library::class);
    }
}
