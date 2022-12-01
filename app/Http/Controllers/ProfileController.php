<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileGetRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Models\Profit;
use App\Models\Session;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(ProfileGetRequest $request)
    {
        return Profile::query()
            ->where('id', '=', $request->input('profile_id'))
            ->first();
    }

    public function store(ProfileRequest $request)
    {
        $profile = Profile::query()->where('email', '=', $request->input('email'))->first();

        if ($profile) {
            return response()->json(['error' => 'This email is already taken'], 400);
        }

        $newProfile = new Profile();
        $newProfile->fill($request->all());

        if ($newProfile->save()) {
            $session = new Session();
            $session->profile_id = $newProfile->id;
            $session->uid = md5(Str::random());
            $session->timestamp_start = time();
            $session->save();

            $profit = new Profit();
            $profit->profile_id = $newProfile->id;
            $profit->pages_per_day = 0;
            $profit->books_per_week = 0;
            $profit->pages_still = $request->input('need_pages') ?: 0;
            $profit->books_still = $request->input('need_books') ?: 0;
            $profit->save();

            return response()->json(['id' => $newProfile->id, 'token' => $session->uid], 201);
        }

        return response()->json(['error' => 'Unable to create profile'], 400);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $profile = Profile::query()->where('id', '=', $request->input('profile_id'))->first();

        if (!$profile) {
            return response()->json(['error' => 'Invalid profile'], 304);
        }

        $profile->fill($request->all())->save();

        ProfitController::update($request);

        return response()->json($profile);
    }
}
