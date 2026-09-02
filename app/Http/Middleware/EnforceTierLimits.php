<?php

namespace App\Http\Middleware;

use App\Models\SiteConfig;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceTierLimits
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user->isAdmin() || SiteConfig::isFreeMode()) {
            return $next($request);
        }

        $profile = $user->merchantProfile;

        // Block if profile is pending (paid tier awaiting admin approval)
        if ($profile && $profile->isPending()) {
            return back()->with('error', 'Your profile is pending approval. You can post once your payment is confirmed by admin.');
        }

        $category = $request->input('category');

        if (! $user->canCreatePost($category)) {
            $tier = $profile->tier;

            $message = $tier->maxPosts() !== null
                ? "You've reached your {$tier->label()} posting limit ({$tier->maxPosts()} post(s), {$tier->maxCategories()} category/categories). Upgrade your tier to post more."
                : 'You cannot create more posts at this time.';

            return back()->with('error', $message);
        }

        return $next($request);
    }
}
