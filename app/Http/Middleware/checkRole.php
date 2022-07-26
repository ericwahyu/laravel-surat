<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedRoles = array_slice(func_get_args(), 2);
        $user = Auth::user();
        if(Auth::check()){
            if(in_array($user->isAdmin(), $allowedRoles)){
                return $next($request);

            }elseif(in_array($user->isPimpinan(), $allowedRoles)){
                return $next($request);

            }elseif(in_array($user->isPengelola(), $allowedRoles)){
                return $next($request);
            }
        }
        return \abort(403);
    }
}
