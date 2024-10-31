<?php

namespace App\Http\Requests\book;

use App\Http\Requests\BaseRequest;

class BookReadRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'book_id' => 'required|int',
        ];
    }
}
