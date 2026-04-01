<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEmployeeAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((Auth::guard('user')->user()->role === 'employee' && Auth::guard('user')->user()->status) || Auth::guard('user')->user()->role === 'admin') {
            return $next($request);
        }
        return error('some thing went wrong', 'Forbidden', 403);
    }
}
