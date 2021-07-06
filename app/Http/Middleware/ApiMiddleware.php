<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check())
            return $next($request);

        $user = $request->user();

        $key = 'last_seen_' . $user->id;
        $value = time();
        Cache::put($key, $value, 60 * 10);

        if (!$user->online) {
            $user->setOnline();
        }

        return $next($request);
    }
}
