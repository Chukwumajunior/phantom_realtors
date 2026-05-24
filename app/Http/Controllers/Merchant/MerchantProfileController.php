<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMerchantRequest;
use Illuminate\Http\Request;

class MerchantProfileController extends Controller
{
    public function edit(Request $request)
    {
        $profile = $request->user()->merchantProfile;

        return view('merchant.profile.edit', compact('profile'));
    }

    public function update(UpdateMerchantRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('merchant-logos', 'public');
        }

        $request->user()->merchantProfile->update($data);

        return back()->with('success', 'Business profile updated successfully.');
    }
}
