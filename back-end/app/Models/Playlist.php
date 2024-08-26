<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'playlist_name',
        'songs_amount',
        'image_path'
    ];

    protected $table = 'playlists';
}
