<?php

namespace App\Http\Controllers;

use App\Http\Requests\gener\GenerAddRequest;
use App\Http\Requests\gener\GenerEditRequest;
use App\Models\Gener;

class GenerController extends BaseController
{
    public function index()
    {
        $models = Gener::all();

        return $this->response($models);
    }

    public function add(GenerAddRequest $request)
    {
        $data = $request->validated();

        $existsGener = Gener::where('title', '=', $data['title'])->first();
        if ($existsGener) {
            return $this->response(['message' => 'Жанр уже создан'], false, 500);
        }

        $model = Gener::create($data);

        return $this->response($model);
    }

    public function edit(GenerEditRequest $request)
    {
        $data = $request->validated();

        $gener = Gener::where('id', '=', $data['gener_id'])->first();
        if (!$gener) {
            return $this->response(['message' => 'Жанр не найден!'], false, 404);
        }

        unset($data['gener_id']);
        if ($data) {
            $gener->update($data);
            return $this->response(['message' => 'Жанр успешно обновлен!']);
        }

        return $this->response(['message' => 'Нечего обновлять!']);
    }
}
