<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\Response;

class AuthAdmin
{
    public function handle($request, Closure $next)
    {
        try {
            if ($request->token->admin) {
                return $next($request);
            }
        } catch (\Throwable $e) { }
        return Response::error("admin permission is required");
    }
}