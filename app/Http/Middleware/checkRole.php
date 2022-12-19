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
        // dd($allowedRoles);
        $user = Auth::user();
        if(Auth::check()){
            foreach($allowedRoles as $role){
                if('Admin' == $role && $user->isAdmin()){
                    return $next($request);
                }elseif('Pimpinan' == $role && $user->isPimpinan()){
                    return $next($request);
                }elseif('Pengelola' == $role && $user->isPengelola()){
                    return $next($request);
                }elseif('User' == $role && $user->isUser()){
                    return $next($request);
                }
            }
            return \abort(403);
        }
        return \abort(403);
    }
}
