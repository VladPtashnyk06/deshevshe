<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminRoleAuthenticateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->role == 'admin') {
            return $next($request);
        }
        return redirect()->route('product.index');
    }
}
