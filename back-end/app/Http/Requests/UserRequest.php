<?php

namespace App\Http\Requests;

use App\Http\RequestModels\UserModel;

class UserRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'email' => ['required', 'string'],
            'username' => ['required', 'string']
        ];
    }

    public function body(): UserModel
    {
        $model = new UserModel();

        $model->login = $this->string('login');
        $model->password = $this->string('password');
        $model->email = $this->string('email');
        $model->username = $this->string('username');

        return $model;
    }
}
