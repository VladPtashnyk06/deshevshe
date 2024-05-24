<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OperatorRoleAuthenticateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::user()->role == 'operator') {
            return $next($request);
        }
        return redirect()->route('product.index');
    }
}
