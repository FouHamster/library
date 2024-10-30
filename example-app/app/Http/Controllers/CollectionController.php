<?php

namespace App\Http\Controllers;

use App\Http\Requests\collection\CollectionAddBookRequest;
use App\Http\Requests\collection\CollectionCreateRequest;
use App\Http\Requests\collection\CollectionViewRequest;
use App\Models\Book;
use App\Models\Collection;
use App\Models\CollectionBook;
use Illuminate\Http\Request;

class CollectionController extends BaseController
{
    public function index(Request $request)
    {
        $models = Collection::where('user_id', '=', $request->user()->id)->paginate(10)->items();

        return $this->response($models);
    }

    public function create(CollectionCreateRequest $request)
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

    public function addBook(CollectionAddBookRequest $request)
    {
        $data = $request->validated();

        $book = Book::where('id', '=', $data['book_id'])->first();
        if (!$book) {
            return $this->response(['message' => 'Такой книги не существует'], false, 404);
        }

        $collection = Collection::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $data['collection_id'])
            ->first();
        if (!$collection) {
            return $this->response(['message' => 'У вас нет такой коллекции'], false, 500);
        }

        $existsBookInCollection = CollectionBook::where('collection_id', '=', $collection->id)
            ->where('book_id', '=', $book->id)
            ->first();

        if ($existsBookInCollection) {
            return $this->response(['message' => 'Книга уже добавленав коллекцию!'], false, 500);
        }

        $model = new CollectionBook();
        $model->collection_id = $data['collection_id'];
        $model->book_id = $data['book_id'];
        if (!$model->save()) {
            return $this->response(['message' => 'Не удалось добавить книгу в коллекцию!'], false, 500);
        }

        return $this->response(['message' => 'Книга успешно добавлена в коллекцию!']);
    }

    public function view(CollectionViewRequest $request)
    {
        $data = $request->validated();

        $collection = Collection::where('id', '=', $data['id'])
            ->where('user_id', '=', $request->user()->id)
            ->first();
        if (!$collection) {
            return $this->response(['message' => 'Коллекция не найдена'], false, 404);
        }

        $books = Book::select('books.*')
            ->with(['author', 'gener'])
            ->leftJoin('collection_books', 'books.id', '=', 'collection_books.book_id')
            ->where('collection_books.collection_id', '=', $collection->id)
            ->get();

        return $this->response($books);
    }
}
