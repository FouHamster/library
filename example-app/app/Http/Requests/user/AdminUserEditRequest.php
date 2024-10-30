<?php

namespace App\Http\Requests\user;

use App\Http\Requests\BaseRequest;

class AdminUserEditRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'role_id' => 'required|int',
            'user_id' => 'required|int'
        ];
    }
}
