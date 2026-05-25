<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteConfig;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $bankDetails = SiteConfig::getBankDetails();
        $plans = SubscriptionPlan::orderBy('price')->get();

        return view('admin.settings.index', compact('bankDetails', 'plans'));
    }

    public function updateBankDetails(Request $request)
    {
        $request->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
        ]);

        SiteConfig::set('bank_details', [
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', 'Bank details updated successfully.');
    }

    public function updatePlan(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $plan->update([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', "Plan \"{$plan->name}\" updated successfully.");
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        SubscriptionPlan::create([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return back()->with('success', 'New subscription plan created.');
    }

    public function destroyPlan(SubscriptionPlan $plan)
    {
        $plan->delete();

        return back()->with('success', 'Plan deleted.');
    }
}
