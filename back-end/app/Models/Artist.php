<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $table = 'artists';

    protected $fillable = [
        'user_id',
        'artist_name',
        'monthly_listeners',
        'image_path'
    ];
}
