<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Property;
use App\Models\Service;

class HomeController extends Controller
{
    public function __invoke()
    {
        $featuredProperties = Property::available()->featured()
            ->with('images')->latest()->take(6)->get();

        $featuredProducts = Product::active()->featured()
            ->with('images')->latest()->take(8)->get();

        $featuredServices = Service::active()->featured()
            ->with('images')->latest()->take(6)->get();

        return view('home', compact('featuredProperties', 'featuredProducts', 'featuredServices'));
    }
}
