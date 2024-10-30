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
}
