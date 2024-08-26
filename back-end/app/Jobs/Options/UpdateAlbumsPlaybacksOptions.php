<?php

namespace App\Jobs\Options;

use Illuminate\Support\Collection;

class UpdateAlbumsPlaybacksOptions
{
    public function __construct(public readonly Collection $albumsIds)
    {}
}
