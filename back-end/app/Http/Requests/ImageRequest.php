<?php

namespace App\Http\Requests;

use App\Http\RequestModels\ImageModel;

class ImageRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required', 'mimes:png'],
        ];
    }

    public function body(): ImageModel
    {
        $model = new ImageModel();
        $model->image = $this->file('image');
        return $model;
    }
}
