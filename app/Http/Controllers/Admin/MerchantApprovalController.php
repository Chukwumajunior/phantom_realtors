<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MerchantStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\MerchantProfile;
use Illuminate\Http\Request;

class MerchantApprovalController extends Controller
{
    public function index()
    {
        $merchants = MerchantProfile::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.merchants.index', compact('merchants'));
    }

    public function show(MerchantProfile $merchantProfile)
    {
        $merchantProfile->load('user');

        return view('admin.merchants.show', ['merchant' => $merchantProfile]);
    }

    public function approve(MerchantProfile $merchantProfile)
    {
        $merchantProfile->update([
            'status' => MerchantStatus::Approved,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        // Change user role to merchant upon approval
        $merchantProfile->user->update(['role' => UserRole::Merchant]);

        return back()->with('success', 'Merchant approved successfully.');
    }

    public function reject(Request $request, MerchantProfile $merchantProfile)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $merchantProfile->update([
            'status' => MerchantStatus::Rejected,
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Merchant rejected.');
    }
}
