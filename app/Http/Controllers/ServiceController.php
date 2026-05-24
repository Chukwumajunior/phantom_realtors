<?php

namespace App\Http\Controllers;

use App\Enums\ServiceCategory;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', [
            'categories' => ServiceCategory::cases(),
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

        return view('services.show', compact('service', 'relatedServices'));
    }
}
