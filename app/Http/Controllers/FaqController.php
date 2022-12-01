<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqGetRequest;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(FaqGetRequest $request)
    {
        return response()->json(Faq::query()
            ->where('id', '=', $request->input('id'))
            ->first());
    }
}
