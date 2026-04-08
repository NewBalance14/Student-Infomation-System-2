<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->is_verified) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
} 