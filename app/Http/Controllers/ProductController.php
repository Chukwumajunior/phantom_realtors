<?php

namespace App\Http\Controllers;

use App\Enums\ProductCategory;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', [
            'categories' => ProductCategory::cases(),
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['images', 'merchant.merchantProfile', 'reviews.user']);
        $product->increment('views_count');

        $relatedProducts = Product::active()
            ->with('images')
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(4)->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
