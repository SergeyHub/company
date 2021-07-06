<?php

namespace App\Http\Middleware;

use Closure;

class LanguageSet
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
        $lang = $request->get('lang');
        if($lang && in_array($lang, config('translatable.locales')))
            \App::setLocale($lang);
        return $next($request);
    }
}
