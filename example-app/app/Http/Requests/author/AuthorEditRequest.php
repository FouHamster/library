<?php

namespace App\Http\Requests\author;

use App\Http\Requests\BaseRequest;

class AuthorEditRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'author_id' => 'required|int',
            'name' => 'string',
            'surname' => 'string',
        ];
    }
}
