<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePosterProfile
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        if (! $user || ! $user->merchantProfile) {
            return redirect()->route('merchant.setup')
                ->with('info', 'Please set up your posting profile to start creating listings.');
        }

        return $next($request);
    }
}
