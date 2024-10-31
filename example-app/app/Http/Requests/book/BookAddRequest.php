<?php

namespace App\Http\Requests\book;

use App\Http\Requests\BaseRequest;

class BookAddRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'img' => 'required|file|max:1048576|extensions:jpg,png',
            'title' => 'required|string',
            'author_id' => 'required|int',
            'year_of_publication' => 'required|string',
            'gener_id' => 'required|int',
            'language' => 'required|string',
            'content_file' => 'required|file|mimes:pdf|max:10000',
        ];
    }
}
