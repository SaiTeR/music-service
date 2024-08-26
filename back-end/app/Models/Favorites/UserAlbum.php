<?php

namespace App\Models\Favorites;

use Illuminate\Database\Eloquent\Model;

class UserAlbum extends Model
{
    use HasFactory;

    protected $table = 'user_album';

    protected $fillable = [
        'user_id',
        'album_id',

    ];

    protected $casts = [

    ];
}
