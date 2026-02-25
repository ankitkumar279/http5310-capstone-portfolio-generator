<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsernameMustMatchAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeUsername = $request->route('username');

        // Must be logged in because this middleware will be used inside auth group
        if (!$request->user()) {
            abort(401);
        }

        // If URL username doesn't match logged-in user's username -> 404 (or 403)
        if ((string)$routeUsername !== (string)$request->user()->username) {
            abort(404);
        }

        return $next($request);
    }
}