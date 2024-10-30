<?php

namespace App\Http\Requests\collection;

use App\Http\Requests\BaseRequest;

class CollectionViewRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'id' => 'required|int',
        ];
    }
}
