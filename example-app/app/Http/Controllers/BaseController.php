<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    public function response($data, $success = true, $code = 200): JsonResponse
    {
        $message = [
            'success' => $success,
            'data' => $data
        ];

        return response()->json($message, $code);
    }
}
