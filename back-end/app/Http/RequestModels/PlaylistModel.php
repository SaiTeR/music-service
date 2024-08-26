<?php

namespace App\Http\RequestModels;

use Illuminate\Http\UploadedFile;

class PlaylistModel
{
    public string $playlistName;
    public UploadedFile $image;
}
