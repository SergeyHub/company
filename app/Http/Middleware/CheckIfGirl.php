<?php

namespace App\Http\Middleware;

use App\Exceptions\UserPermissionTypeException;
use Closure;

class CheckIfGirl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @throws UserPermissionTypeException
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->isGirl()) {
            return $next($request);
        }
        throw new UserPermissionTypeException('User is not girl type');
    }

}
