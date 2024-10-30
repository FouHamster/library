<?php

namespace App\Http\Requests\rent;

use App\Http\Requests\BaseRequest;

class RentAddBookRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'book_id' => 'required|int',
            'date_start' => 'required|date|after:tomorrow',
            'date_end' => 'required|date|after:date_start',
            'address' => 'required|string',
        ];
    }
}
