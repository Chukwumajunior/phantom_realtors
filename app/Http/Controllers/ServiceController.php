<?php

namespace App\Http\Controllers;

use App\Enums\ServiceGroup;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', [
            'hierarchy' => ServiceGroup::hierarchy(),
        ]);
    }

    public function show(Service $service)
    {
        $service->load(['images', 'merchant.merchantProfile', 'reviews.user']);
        $service->increment('views_count');

        $relatedServices = Service::active()
            ->with('images')
            ->where('id', '!=', $service->id)
            ->where('category', $service->category)
            ->take(4)->get();

        // Fallback: fill from same group if not enough same-category results
        if ($relatedServices->count() < 4) {
            $remaining = 4 - $relatedServices->count();
            $groupRelated = Service::active()
                ->with('images')
                ->where('id', '!=', $service->id)
                ->whereNotIn('id', $relatedServices->pluck('id'))
                ->ofGroup($service->category->group())
                ->take($remaining)->get();
            $relatedServices = $relatedServices->merge($groupRelated);
        }

        return view('services.show', compact('service', 'relatedServices'));
    }
}
