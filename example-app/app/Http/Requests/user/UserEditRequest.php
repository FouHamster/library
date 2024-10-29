<?php

namespace App\Http\Requests\user;

use App\Http\Requests\BaseRequest;

class UserEditRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'password' => 'string|confirmed|min:2',
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'phone' => 'string|regex:/(7)[0-9]{10}/',
        ];
    }
}
