<?php

namespace App\Http\Requests\collection;

use App\Http\Requests\BaseRequest;

class CollectionCreateRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'title' => 'string|max:255|min:3',
        ];
    }
}
