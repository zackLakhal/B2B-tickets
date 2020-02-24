<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'client':if (Auth::guard($guard)->check()) {
                return redirect('client');
            }
            
                break;
            
                case  'nst':if (Auth::guard($guard)->check()) {
                    return redirect('nst');
                }
                # code...
                break;
        }
        

        return $next($request);
    }
}
