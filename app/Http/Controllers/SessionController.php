<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use App\Http\Services\SessionService;
use App\Models\Profile;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class SessionController extends Controller
{
    private SessionService $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function store(SessionRequest $request)
    {
        $profile = Profile::query()
            ->where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 401);
        }

        $token = $this->sessionService->saveSession($profile);

        if ($token) {
            return response()
                ->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unable to create a session'], 400);
    }
}
