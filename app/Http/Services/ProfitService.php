<?php

namespace App\Http\Services;

use App\Models\Profit;

class ProfitService
{
    public function saveProfit($request, $newProfile): void
    {
        $profit = new Profit();
        $profit->profile_id = $newProfile->id;
        $profit->pages_per_day = 0;
        $profit->books_per_week = 0;
        $profit->pages_still = $request->input('need_pages') ?: 0;
        $profit->books_still = $request->input('need_books') ?: 0;
        $profit->save();
    }
}
