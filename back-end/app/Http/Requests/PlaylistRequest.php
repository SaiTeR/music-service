<?php

namespace App\Http\Requests;

use App\Http\RequestModels\PlaylistModel;

class PlaylistRequest extends BaseFormRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'playlistName' => ['required', 'string'],
            'image' => ['nullable', 'mimes:png'],
        ];
    }

    public function body(): PlaylistModel
    {
        $model = new PlaylistModel();

        $model->playlistName = $this->string('playlistName');
        $model->image = $this->file('image');

        return $model;
    }
}
