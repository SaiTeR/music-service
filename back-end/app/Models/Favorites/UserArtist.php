<?php

namespace App\Models\Favorites;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserArtist extends Model
{
    use HasFactory;

    protected $table = 'user_artist';

    protected $fillable = [
        'user_id',
        'artist_id',

    ];

    protected $casts = [

    ];
}
