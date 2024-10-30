<?php

namespace App\Http\Requests\collection;

use App\Http\Requests\BaseRequest;

class CollectionAddBookRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'collection_id' => 'required|int',
            'book_id' => 'required|int',
        ];
    }
}
