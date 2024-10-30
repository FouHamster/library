<?php

namespace App\Http\Controllers;

use App\Http\Requests\rent\RentAddBookRequest;
use App\Models\Book;
use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends BaseController
{
    public function index(Request $request)
    {
        $search = $request->get('search'); // поиск
        if ($search) {
            $searchedUser = Rent::select('rents.*')
                ->with(['user', 'book', 'book.author', 'book.gener'])
                ->leftJoin('users', 'users.id', '=', 'rents.user_id')
                ->leftJoin('books', 'books.id', '=', 'rents.book_id')
                ->leftJoin('geners', 'geners.id', '=', 'books.gener_id')
                ->leftJoin('authors', 'authors.id', '=', 'books.author_id')
                ->orWhere('rents.address', 'like', "%$search%")
                ->orWhere('users.name', 'like', "%$search%")
                ->orWhere('users.surname', 'like', "%$search%")
                ->orWhere('users.phone', 'like', "%$search%")
                ->orWhere('books.title', 'like', "%$search%")
                ->orWhere('books.year_of_publication', 'like', "%$search%")
                ->orWhere('books.language', 'like', "%$search%")
                ->orWhere('geners.title', 'like', "%$search%")
                ->orWhere('authors.name', 'like', "%$search%")
                ->orWhere('authors.surname', 'like', "%$search%")
                ->get();
            return $this->response($searchedUser);
        }

        $models = Rent::with(['user', 'book', 'book.author', 'book.gener'])->paginate(10)->items();
        return $this->response($models);
    }

    public function my(Request $request)
    {
        $models = Rent::with(['user', 'book', 'book.author', 'book.gener'])
            ->where('user_id', '=', $request->user()->id)
            ->paginate(10)
            ->items();

        return $this->response($models);
    }

    public function add(RentAddBookRequest $request)
    {
        $data = $request->validated();

        $book = Book::where('id', '=', $data['book_id'])->first();
        if (!$book) {
            return $this->response(['message' => 'Такой книги нету'], false, 404);
        }

        $currentRent = Rent::where('user_id', '=', $request->user()->id)
            ->where('book_id', '=', $book->id)
            ->where('date_end', '>=', date('Y-m-d'))
            ->first();
        if ($currentRent) {
            return $this->response(['message' => 'Вы уже арендовали эту книгу!'], false, 500);
        }

        $model = new Rent();
        $model->user_id = $request->user()->id;
        $model->book_id = $book->id;
        $model->date_start = $data['date_start'];
        $model->date_end = $data['date_end'];
        $model->address = $data['address'];
        if (!$model->save()) {
            return $this->response(['message' => 'Не удалось арендовать книгу!'], false, 500);
        }

        return $this->response(['message' => 'Аренда успешно отправлена!']);
    }
}
