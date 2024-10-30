<?php

namespace App\Http\Requests\gener;

use App\Http\Requests\BaseRequest;

class GenerAddRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string',
        ];
    }
}
