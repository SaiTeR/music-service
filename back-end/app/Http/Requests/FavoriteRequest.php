<?php

namespace App\Http\Requests;

use App\Http\RequestModels\ArtistModel;
use App\Http\RequestModels\FavoriteModel;

class FavoriteRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'int'],
        ];
    }

    public function body(): FavoriteModel
    {
        $model = new FavoriteModel();

        $model->id = $this->int('id');

        return $model;
    }
}
