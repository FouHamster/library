<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

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

        $models = Book::with(['author', 'gener']);  // Выводим все книги

        //фильтрация
        if ($request->get('language')) {
            $models->where('books.language', '=', $request->get('language'));
        }

        return $this->response($models->get());
    }
}
