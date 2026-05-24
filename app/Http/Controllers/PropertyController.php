<?php

namespace App\Http\Controllers;

use App\Enums\PropertyCategory;
use App\Enums\PropertyType;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        return view('properties.index', [
            'types' => PropertyType::cases(),
            'categories' => PropertyCategory::cases(),
        ]);
    }

    public function show(Property $property)
    {
        $property->load(['images', 'merchant.merchantProfile', 'reviews.user']);
        $property->increment('views_count');

        $relatedProperties = Property::available()
            ->where('id', '!=', $property->id)
            ->where('category', $property->category)
            ->with('images')
            ->take(4)->get();

        return view('properties.show', compact('property', 'relatedProperties'));
    }
}
