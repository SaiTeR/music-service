<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';

    protected $fillable = [
        'artist_id',
        'album_name',
        'release_year',
        'is_explicit',
        'album_type',
        'genre',
        'playbacks'
    ];

    protected $casts = [
        'release_year' => 'string'
    ];
}
