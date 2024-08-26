<?php

namespace App\Models\Favorites;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSong extends Model
{
    use HasFactory;

    protected $table = 'user_song';

    protected $fillable = [
        'user_id',
        'song_id',

    ];

    protected $casts = [

    ];
}
