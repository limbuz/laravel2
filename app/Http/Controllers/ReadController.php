<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadGetRequest;
use App\Http\Requests\ReadRequest;
use App\Models\Book;
use App\Models\Read;

class ReadController extends Controller
{
    public function index(ReadGetRequest $request)
    {
        $timestamp_start = $request->input('timestamp_start');
        $timestamp_end   = $request->input('timestamp_end');

        $read = Read::query()
                    ->where('profile_id', '=', $request->input('profile_id'));

        if ($timestamp_start && $timestamp_end) {
            $read
                ->where('timestamp', '>=', $timestamp_start)
                ->where('timestamp', '<=', $timestamp_end);
        }

        if ($request->input('book_id')) {
            $read->where('book_id', '=', $request->input('book_id'));
        }

        if ($request->input('genre')) {
            $books = Book::all()->where('genre', '=', $request->input('genre'))->toArray();
            $read->whereIn('book_id', array_column($books, 'id'));
        }

        return response()->json($read->get());
    }

    public function store(ReadRequest $request)
    {
        $newRead = new Read();
        $newRead->fill(array_merge(['profile_id' => $request->input('profile_id')], $request->all()));
        $newRead->save();

        ProfitController::update($request);

        return response()->json($newRead, 201);
    }

    public function update(ReadRequest $request)
    {
        $read = Read::query()->where('id', '=', $request->input('id'))->first();

        if (!$read) {
            return response()->json(['error' => 'Invalid read'], 304);
        }

        $read->fill(array_merge(['profile_id' => $request->input('profile_id')], $request->all()))->save();

        ProfitController::update($request);

        return response()->json($read);
    }
}
