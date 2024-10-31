<?php

namespace App\Http\Requests\book;

use App\Http\Requests\BaseRequest;

class BookEditRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'book_id' => 'required|int',
            'img' => 'file|max:1048576|extensions:jpg,png',
            'title' => 'string',
            'author_id' => 'int',
            'year_of_publication' => 'string',
            'gener_id' => 'int',
            'language' => 'string',
            'content_file' => 'file|mimes:pdf|max:10000',
        ];
    }
}
