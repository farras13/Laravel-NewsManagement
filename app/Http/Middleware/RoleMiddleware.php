<?php

namespace App\Http\Middleware;

use App\Helpers\ApiFormatter;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
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
        $auth = isset(auth()->user()->is_admin) == 1;
        if (!$auth) return ApiFormatter::createApi(500, "You don't have permission!");
        return $next($request);
    }
}
