<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Admin bypasses subscription check entirely
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        if (!$user || !$user->hasActiveSubscription()) {
            return redirect()->route('merchant.subscription.expired');
        }

        return $next($request);
    }
}
