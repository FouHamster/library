<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

class ValidationException extends HttpResponseException
{
    public function __construct($code = 422, $message = 'Validation error', $errors = []) //конструктор валидации
    {
        $data = [
            'success' => false,
            'data' => [
                'code' => $code,
                'message' => $message,
            ],
        ];

        if (count($errors) > 0) {
            $data['data']['errors'] = $errors;
        }

        parent::__construct(response()->json($data)->setStatusCode($code, $message));
    }

}
