<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileGetRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Services\ProfitService;
use App\Http\Services\SessionService;
use App\Models\Profile;
use App\Models\Profit;
use App\Models\Session;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    private SessionService $sessionService;
    private ProfitService  $profitService;

    public function __construct(SessionService $sessionService, ProfitService $profitService)
    {
        $this->sessionService = $sessionService;
        $this->profitService  = $profitService;
    }

    public function index(ProfileGetRequest $request)
    {
        return Profile::query()
            ->where('id', '=', $request->input('profile_id'))
            ->first();
    }

    public function store(ProfileRequest $request)
    {
        $newProfile = new Profile();
        $newProfile->fill($request->all());

        if ($newProfile->save()) {
            $token = $this->sessionService->saveSession($newProfile);
            $this->profitService->saveProfit($request, $newProfile);

            return response()->json(['id' => $newProfile->id, 'token' => $token], 201);
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
