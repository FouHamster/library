<?php

namespace App\Http\Requests\user;

use App\Http\Requests\BaseRequest;

class UserRegisterRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed|min:2',
            'name' => 'required|string|max:255',
            'surname' => 'string|max:255',
            'phone' => 'required|string|regex:/(7)[0-9]{10}/',
        ];
    }
}
