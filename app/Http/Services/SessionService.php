<?php

namespace App\Http\Services;

use App\Models\Session;
use Illuminate\Support\Str;

class SessionService
{
    public static function saveSession($newProfile): string
    {
        $session = new Session();
        $session->profile_id = $newProfile->id;
        $session->uid = md5(Str::random());
        $session->timestamp_start = time();
        $session->save();

        return $session->uid;
    }
}
