<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use App\Models\Profile;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class SessionController extends Controller
{
    public function store(SessionRequest $request)
    {
        $profile = Profile::query()
            ->where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 401);
        }

        $session = new Session();
        $session->profile_id = $profile->id;
        $session->uid = md5(Str::random());
        $session->timestamp_start = time();

        if ($session->save()) {
            return response()
                ->json(['token' => $session->uid]);
        }

        return response()->json(['error' => 'Unable to create a session'], 400);
    }
}
