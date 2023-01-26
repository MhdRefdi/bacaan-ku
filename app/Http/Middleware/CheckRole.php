<?php

namespace App\Http\Middleware;

use App\Helpers\ApiFormatter;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->user()->role != $role) {
            return response('Unauthorize', 403);
            // abort(403);
        }

        return $next($request);
    }
}
