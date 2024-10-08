<?php

namespace App\Facades;

use App\Models\TokenPayloadModel;
use Illuminate\Support\Facades\Request;

class AuthFacade
{
    public static function getAuthInfo(): TokenPayloadModel
    {
        return Request::instance()->get('authInfo');
    }
}
