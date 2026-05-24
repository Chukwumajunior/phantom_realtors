<?php

namespace App\Http\Middleware;

use App\Enums\MerchantStatus;
use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMerchantApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== UserRole::Merchant) {
            abort(403);
        }

        $profile = $user->merchantProfile;

        if (!$profile || $profile->status !== MerchantStatus::Approved) {
            return redirect()->route('merchant.pending-approval');
        }

        return $next($request);
    }
}
