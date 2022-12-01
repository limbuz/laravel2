<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Http\Request;

class CheckAuthToken
{
    const SESSION_DURATION = 86400;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('token') || !$request->input('token')) {
            return response()->json(['error' => 'Invalid Auth-Token'], 401);
        }

        $token = $request->header('token');
        if (!$token) {
            $token = $request->input('token');
        }

        $hasUid = Session::query()
            ->where('uid', '=', $request->header('token'))
            ->first();

        if ($hasUid && $hasUid->timestamp_start > time() + self::SESSION_DURATION) {
            return response()->json(['error' => 'Expired Auth-Token'], 401);
        }

        $request->merge(['profile_id' => $hasUid->profile_id]);

        return $next($request);
    }
}
