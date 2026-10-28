<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
       public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()->isadmin) {
            return abort(403);
        }

        return $next($request);
    }
}
