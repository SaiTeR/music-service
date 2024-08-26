<?php

namespace App\DTO;

class PlaylistDTO
{
    public int $id;
    public string $playlistName;
    public string $ownerName;
    public int $songsAmount;
    public string $imageUrl;

    public function __construct(int $id, string $playlistName, string $ownerName, int $songsAmount, string $imageUrl)
    {
        $this->id = $id;
        $this->playlistName = $playlistName;
        $this->ownerName = $ownerName;
        $this->songsAmount = $songsAmount;
        $this->imageUrl = $imageUrl;
    }
}
