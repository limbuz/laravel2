<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfitGetRequest;
use App\Models\Book;
use App\Models\Profile;
use App\Models\Profit;
use App\Models\Read;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    const SECONDS_IN_WEEK = 60 * 60 * 24 * 7;
    const SECONDS_IN_DAY = 60 * 60 * 24;

    public function index(ProfitGetRequest $request)
    {
        $timestamp_start = $request->input('timestamp_start');
        $timestamp_end   = $request->input('timestamp_end');

        $profit = Profit::query()
            ->where('profile_id', '=', $request->input('profile_id'));

        if ($timestamp_start && $timestamp_end) {
            $profit
                ->where('timestamp', '>=', $timestamp_start)
                ->where('timestamp', '<=', $timestamp_end);
        }

        if ($request->input('book_id')) {
            $profit->where('book_id', '=', $request->input('book_id'));
        }

        if ($request->input('genre')) {
            $books = Book::all()->where('genre', '=', $request->input('genre'))->toArray();
            $profit->whereIn('book_id', array_column($books, 'id'));
        }

        $pagesTotal = Read::query()->where('profile_id', '=', $request->input('profile_id'))->sum('pages');
        $booksTotal = Book::all()
            ->where('profile_id', '=', $request->input('profile_id'))
            ->where('is_read', '=', true)
            ->count();

        return response()->json(array_merge($profit->get()->first()->toArray(), ['pages_total' => $pagesTotal, 'books_total' => $booksTotal]));
    }

    public static function update(Request $request)
    {
        $profile = Profile::query()
            ->where('id', '=', $request->input('profile_id'))
            ->first();

        $profit = Profit::query()
            ->where('profile_id', '=', $request->input('profile_id'))
            ->first();

        if (!$profit) {
            $profit = new Profit();
            $profit->profile_id = $profile->id;
        }

        $readBooks = Book::all()
            ->where('profile_id', '=', $request->input('profile_id'))
            ->where('is_read', '=', true);
        $weeks      = ceil(($profile->timestamp_end - $profile->timestamp_start) / self::SECONDS_IN_WEEK);
        $daysPassed = (int)ceil((time() - $profile->timestamp_start) / self::SECONDS_IN_DAY) === 0  ?: 1;
        $pagesRead  = Read::query()->where('profile_id', '=', $request->input('profile_id'))->sum('pages');

        $profit->pages_per_day  = $pagesRead / $daysPassed;
        $profit->books_per_week = ceil(count($readBooks) / $weeks);
        $profit->pages_still    = $profile->need_pages - $pagesRead;
        $profit->books_still    = $profile->need_books - count($readBooks);

        $profit->save();
    }
}
