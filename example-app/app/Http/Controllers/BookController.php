<?php

namespace App\Http\Controllers;

use App\Http\Requests\book\BookAddRequest;
use App\Http\Requests\book\BookEditRequest;
use App\Http\Requests\book\BookReadRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Gener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends BaseController
{
    public function index(Request $request)
    {
        $search = $request->get('search'); // поиск
        if ($search) {
            $searchedBooks = Book::select('books.*')
                ->with(['author', 'gener'])
                ->leftJoin('authors', 'authors.id', '=', 'books.author_id')
                ->leftJoin('geners', 'geners.id', '=', 'books.gener_id')
                ->where('books.title', 'like', "%$search%")
                ->orWhere('books.year_of_publication', 'like', "%$search%")
                ->orWhere('books.language', 'like', "%$search%")
                ->orWhere('authors.name', 'like', "%$search%")
                ->orWhere('authors.surname', 'like', "%$search%")
                ->orWhere('geners.title', 'like', "%$search%")
                ->get();
            return $this->response($searchedBooks);
        }

        $models = Book::with(['author', 'gener']) // Выводим все книги
        ->leftJoin('authors', 'authors.id', '=', 'books.author_id')
            ->leftJoin('geners', 'geners.id', '=', 'books.gener_id');

        //фильтрация по языку
        if ($request->get('language')) {
            $models->where('books.language', '=', $request->get('language'));
        }

        //фильтрация по году издания
        if ($request->get('year_of_publication')) {
            $models->where('books.year_of_publication', '=', $request->get('year_of_publication'));
        }

        //фильтрация по жанру
        if ($request->get('gener')) {
            $models->where('geners.title', '=', $request->get('gener'));
        }
        if ($request->get('author_name')) {
            $models->where('authors.name', '=', $request->get('author_name'));
        }
        if ($request->get('author_surname')) {
            $models->where('authors.surname', '=', $request->get('author_surname'));
        }

        return $this->response($models->paginate(10)->items()); //вывод на одной странице
    }

    public function add(BookAddRequest $request)
    {
        $data = $request->validated();

        $gener = Gener::where('id', '=', $data['gener_id'])->first();
        if (!$gener) {
            return $this->response(['message' => 'Ошибка'], false, 404);
        }

        $author = Author::where('id', '=', $data['author_id'])->first();
        if (!$author) {
            return $this->response(['message' => 'Ошибка'], false, 404);
        }

        $imageFile = $request->file('img');
        $imageFilePath = $imageFile->store('uploads', 'public');
        $imageFileLink = asset('storage/' . $imageFilePath);

        $contentFile = $request->file('content_file');
        $contentFilePath = $contentFile->store('uploads', 'public');
        $contentFileLink = asset('storage/' . $contentFilePath);

        $data['img'] = $imageFileLink;
        $data['content_file'] = $contentFileLink;
        $model = Book::create($data);

        return $this->response($model);
    }

    public function edit(BookEditRequest $request)
    {
        $data = $request->validated();

        $book = Book::where('id', '=', $data['book_id'])->first();
        if(!$book){
            return $this->response(['message' => 'Книга не найдена!'], false, 404);
        }

        if (isset($data['img'])) {
            $imageFile = $request->file('img');
            $imageFilePath = $imageFile->store('uploads', 'public');
            $imageFileLink = asset('storage/' . $imageFilePath);

            $currentFilePath = $book->getContentFilePath('img');
            if (file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }
            $data['img'] = $imageFileLink;
        }
        if (isset($data['content_file'])) {
            $contentFile = $request->file('content_file');
            $contentFilePath = $contentFile->store('uploads', 'public');
            $contentFileLink = asset('storage/' . $contentFilePath);

            $currentFilePath = $book->getContentFilePath('content_file');
            if (file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }
            $data['content_file'] = $contentFileLink;
        }

        unset($data['book_id']);
        if($data) {
            $book->update($data);
            return $this->response(['message' => 'Книга успешно обновлена!']);
        }

        return $this->response(['message' => 'Нечего обновлять!']);
    }

    public function read(BookReadRequest $request)
    {
        $data = $request->validated();

        $book = Book::where('id', '=', $data['book_id'])->first();
        if (!$book) {
            return $this->response(['message' => 'Книга не найдена!'], false, 404);
        }

        $filePath = $book->getContentFilePath('content_file');

        return response()->file($filePath);
    }

    public function download(BookReadRequest $request)
    {
        $data = $request->validated();

        $book = Book::where('id', '=', $data['book_id'])->first();
        if (!$book) {
            return $this->response(['message' => 'Книга не найдена!'], false, 404);
        }

        $filePath = $book->getContentFilePath('content_file');

        return response()->download($filePath);
    }
}
