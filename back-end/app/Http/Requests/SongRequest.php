<?php

namespace App\Http\Requests;

use App\Http\RequestModels\SongModel;

class SongRequest extends BaseFormRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'songName' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'isExplicit' => ['required', 'bool'],
            'songType' => ['nullable', 'string'],

            'file' => ['required', 'mimes:mp3'],
        ];
    }

    public function body(): SongModel
    {
        $model = new SongModel();

        $model->songName = $this->string('songName');
        $model->duration = $this->string('duration');
        $model->isExplicit = $this->boolean('isExplicit');
        $model->songType = $this->string('songType');
        $model->file = $this->file('file');

        return $model;
    }
}
