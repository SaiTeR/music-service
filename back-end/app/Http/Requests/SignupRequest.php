<?php

namespace App\Http\Requests;

use App\Http\RequestModels\SignupModel;

class SignupRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' =>['required','string'],
            'email' => ['required', 'email', 'string'],
            'username' => ['required', 'string'],
        ];
    }

    public function body(): SignupModel
    {
        $model = new SignupModel();

        $model->login = $this->string('login');
        $model->password = $this->string('password');
        $model->email = $this->string('email');
        $model->username = $this->string('username');

        return $model;
    }
}
