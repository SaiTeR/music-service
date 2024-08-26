<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';

    protected $fillable = [
        'artist_id',
        'album_id',
        'song_name',
        'duration',
        'is_explicit',
        'song_type',
        'path',
        'playbacks'
    ];
    protected $casts = [
        'duration' => 'string',
    ];
}
