<?php

namespace App\Http\Requests\author;

use App\Http\Requests\BaseRequest;

class AuthorAddRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'surname' => 'required|string',
        ];
    }
}
