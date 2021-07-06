<?php

namespace App\Http\Middleware;

use App\Exceptions\UserPermissionTypeException;
use Closure;

class CheckIfClient
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
        if($request->user()->isClient()) {
            return $next($request);
        }
        throw new UserPermissionTypeException('User is not client type');
    }
}
