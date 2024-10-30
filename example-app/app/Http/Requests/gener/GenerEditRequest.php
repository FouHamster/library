<?php

namespace App\Http\Requests\gener;

use App\Http\Requests\BaseRequest;

class GenerEditRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'gener_id' => 'required|int',
            'title' => 'string',
        ];
    }
}
