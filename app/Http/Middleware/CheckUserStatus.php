<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status == 0) {
            Auth::logout();
            return redirect('/admin/login')->withErrors(['message' => 'Your account has been deactivated by the Quick Line Team. Contact them to Re-Active it.']);
        }

        return $next($request);;
    }
}
