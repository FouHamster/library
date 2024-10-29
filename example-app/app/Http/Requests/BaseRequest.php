<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(422, 'Validation error', $validator->errors());
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages += [
            'exists' => ':attribute does not exist'
        ];
        return $messages;
    }
}
