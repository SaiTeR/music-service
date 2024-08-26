<?php

namespace App\Http\Requests;

use App\Http\RequestModels\LoginModel;

class LoginRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' =>['required','string']
        ];
    }

    public function body(): LoginModel
    {
        $model = new LoginModel();

        $model->login = $this->string('login');
        $model->password = $this->string('password');

        return $model;
    }
}
