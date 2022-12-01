<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckAuthToken;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\FaqController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/authorization', [SessionController::class, 'store']);

Route::post('/create_profile', [ProfileController::class, 'store']);
Route::middleware(CheckAuthToken::class)->post('/update_profile', [ProfileController::class, 'update']);
Route::middleware(CheckAuthToken::class)->get('/get_profile', [ProfileController::class, 'index']);

Route::middleware(CheckAuthToken::class)->get('/search_book', [BookController::class, 'search']);
Route::middleware(CheckAuthToken::class)->post('/add_book', [BookController::class, 'store']);
Route::middleware(CheckAuthToken::class)->post('/mark_book', [BookController::class, 'mark']);
Route::middleware(CheckAuthToken::class)->get('/get_books_list', [BookController::class, 'index']);

Route::middleware(CheckAuthToken::class)->post('/add_read', [ReadController::class, 'store']);
Route::middleware(CheckAuthToken::class)->post('/update_read', [ReadController::class, 'update']);
Route::middleware(CheckAuthToken::class)->get('/get_story_reads', [ReadController::class, 'index']);

Route::middleware(CheckAuthToken::class)->get('/get_profit', [ProfitController::class, 'index']);

Route::get('/get_faq', [FaqController::class, 'index']);
