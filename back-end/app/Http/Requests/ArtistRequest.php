<?php

namespace App\Http\Requests;

use App\Http\RequestModels\ArtistModel;
class ArtistRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'artistName' => ['required', 'string'],
            'image' => ['nullable', 'mimes:png'],
        ];
    }

    public function body(): ArtistModel
    {
        $model = new ArtistModel();

        $model->artistName = $this->string('artistName');
        $model->image = $this->file('image');

        return $model;
    }
}
