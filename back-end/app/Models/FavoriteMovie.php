<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends Model
{
    use HasFactory;

    protected $table = 'favorite_movies';

    protected $fillable = [
        'user_id',
        'tmdb_id',
        'title',
        'poster_path',
        'release_date',
        'overview'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}