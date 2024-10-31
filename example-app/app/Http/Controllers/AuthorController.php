<?php

namespace App\Http\Controllers;

use App\Http\Requests\author\AuthorAddRequest;
use App\Http\Requests\author\AuthorEditRequest;
use App\Models\Author;

class AuthorController extends BaseController
{
    public function index() //вывод всех авторов
    {
        $models = Author::all();

        return $this->response($models);
    }

    public function add(AuthorAddRequest $request) //Добавление автора
    {
        $data = $request->validated();

        $existsAuthor = Author::where('name', '=', $data['name'])
            ->where('surname', '=', $data['surname'])
            ->first();
        if ($existsAuthor) {
            return $this->response(['message' => 'Автор уже создан'], false, 500);
        }

        $model = Author::create($data);

        return $this->response($model);
    }

    public function edit(AuthorEditRequest $request)
    {
        $data = $request->validated();

        $author = Author::where('id', '=', $data['author_id'])->first();
        if (!$author) {
            return $this->response(['message' => 'Автор не найден!'], false, 404);
        }

        unset($data['author_id']);
        if ($data) {
            $author->update($data);
            return $this->response(['message' => 'Автор успешно обновлен!']);
        }

        return $this->response(['message' => 'Нечего обновлять!']);
    }
}
