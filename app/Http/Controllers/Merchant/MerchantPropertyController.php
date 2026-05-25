<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use App\Services\ImageService;
use Illuminate\Http\Request;

class MerchantPropertyController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $properties = $request->user()->properties()
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('merchant.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('merchant.properties.create');
    }

    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();
        $images = $data['images'] ?? [];
        unset($data['images']);

        $data['user_id'] = $request->user()->id;
        $property = Property::create($data);

        if (!empty($images)) {
            $this->imageService->uploadImages($images, 'properties', $property);
        }

        return redirect()->route('merchant.properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function edit(Property $property)
    {
        abort_unless(auth()->user()->isAdmin() || $property->user_id === auth()->id(), 403);
        $property->load('images');

        return view('merchant.properties.edit', compact('property'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $data = $request->validated();
        $images = $data['images'] ?? [];
        unset($data['images']);

        $property->update($data);

        if (!empty($images)) {
            $this->imageService->uploadImages($images, 'properties', $property);
        }

        return redirect()->route('merchant.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        abort_unless(auth()->user()->isAdmin() || $property->user_id === auth()->id(), 403);

        $this->imageService->deleteAllImages($property);
        $property->delete();

        return redirect()->route('merchant.properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}
