<?php

namespace App\Http\RequestModels;

use Illuminate\Http\UploadedFile;

class ArtistModel
{
    public string $artistName;
    public UploadedFile $image;
}
