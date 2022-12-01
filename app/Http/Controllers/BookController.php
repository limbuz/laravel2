<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookGetRequest;
use App\Http\Requests\BookMarkRequest;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookSearchRequest;
use App\Models\Book;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    const FIND_URL = 'https://www.googleapis.com/books/v1/volumes?q=';

    public function index(BookGetRequest $request)
    {
        $list = Book::all()
            ->where('profile_id', '=', $request->input('profile_id'));

        if ($request->input('is_read')) {
            $list->where('is_read', '=', $request->input('is_read'));
        }

        if ($request->input('in_progress')) {
            $list->where('in_progress', '=', $request->input('in_progress'));
        }

        if (!$list) {
            return response()->json(['error' => 'Not Found'], 400);
        }

        return response()->json($list);
    }

    public function store(BookRequest $request)
    {
        $newBook = new Book();
        $newBook->fill([$request->all(), 'profile_id' => $request->input('profile_id')]);

        if ($newBook->save()) {
            return response()->json($newBook, 201);
        }

        return response()->json(['error' => 'Unable to create'], 400);
    }


    public function search(BookSearchRequest $request)
    {
        $response = Http::get(self::FIND_URL . $request->input('query'));

        $data = [];

        $foundBooks = json_decode($response->body(), true)['items'];

        foreach (array_slice($foundBooks, 0, 4) as $book) {
            $info = $book['volumeInfo'];

            $data[] = [
                'name'   => $info['title'],
                'poster' => array_key_exists('imageLinks', $info) ? $info['imageLinks'] : null,
                'pages'  => array_key_exists('pageCount', $info) ? $info['pageCount'] : null,
                'genre'  => array_key_exists('categories', $info) ? $info['categories'] : null,
            ];
        }

        return response()->json($data);
    }

    public function mark(BookMarkRequest $request)
    {
        $book = Book::query()
            ->where('id', '=', $request->input('book_id'))
            ->first();

        $book->fill([$request->all(), 'profile_id' => $request->input('profile_id')])->save();

        return response()->json($book);
    }
}
