<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Property;
use App\Models\Service;
use Illuminate\Http\Request;

class ListingModerationController extends Controller
{
    public function unpublish(Request $request, string $type, int $id)
    {
        $model = $this->resolveModel($type, $id);

        $model->update(['listing_status' => ListingStatus::Inactive]);

        return back()->with('success', 'Listing has been unpublished.');
    }

    public function republish(Request $request, string $type, int $id)
    {
        $model = $this->resolveModel($type, $id);

        $model->update(['listing_status' => ListingStatus::Active]);

        return back()->with('success', 'Listing has been republished.');
    }

    private function resolveModel(string $type, int $id)
    {
        return match ($type) {
            'property' => Property::findOrFail($id),
            'product' => Product::findOrFail($id),
            'service' => Service::findOrFail($id),
            default => abort(404),
        };
    }
}
