<?php

namespace App\Http\Controllers;

use App\Http\Requests\collection\CollectionCreateRequest;
use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $models = Collection::where('user_id', '=', $request->user()->id)->get();

        return $this->response($models);
    }

    public function create(CollectionCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($data) {
            $sameModel = Collection::where('title', '=', $data['title'])
                ->where('user_id', '=', $request->user()->id)
                ->first();
            if ($sameModel) {
                return $this->response(['message' => 'У вас уже есть коллекция с таким названием'], false, 500);
            }
            $data['user_id'] = $request->user()->id;
            $model = Collection::create($data);

            return $this->response($model);
        }

        return $this->response(['message' => 'Не удалось создать коллекцию'], false, 500);
    }
}
