<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'following_user_id',
        'followed_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
