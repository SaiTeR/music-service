<?php

namespace App\DTO;

class ArtistDTO
{
    public int $id;
    public string $artistName;
    public string $ownerName;
    public int $monthlyListeners;
    public string $imageUrl;

    public function __construct(int $id, string $artistName, string $ownerName, int $monthlyListeners, string $imageUrl)
    {
        $this->id = $id;
        $this->artistName = $artistName;
        $this->ownerName = $ownerName;
        $this->monthlyListeners = $monthlyListeners;
        $this->imageUrl = $imageUrl;
    }
}
