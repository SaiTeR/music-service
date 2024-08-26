<?php

namespace App\Http\Requests;

use App\Http\RequestModels\AlbumModel;
use App\Http\RequestModels\SongModel;

class AlbumRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'albumName' => ['required', 'string'],
            'releaseYear' => ['required', 'string'],
            'isExplicit' => ['required', 'bool'],
            'albumType' => ['required', 'string'],
            'genre' => ['required', 'string'],
            'image' => ['nullable', 'mimes:png'],
        ];
    }

    public function body(): AlbumModel
    {
        $model = new AlbumModel();

        $model->albumName = $this->string('albumName');
        $model->releaseYear = $this->string('releaseYear');
        $model->isExplicit = $this->boolean('isExplicit');
        $model->albumType = $this->string('albumType');
        $model->genre = $this->string('genre');
        $model->image = $this->file('image');

        return $model;
    }
}
