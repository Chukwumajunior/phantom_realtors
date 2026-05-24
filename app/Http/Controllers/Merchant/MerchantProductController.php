<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

class MerchantProductController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $products = $request->user()->products()
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('merchant.products.index', compact('products'));
    }

    public function create()
    {
        return view('merchant.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $images = $data['images'] ?? [];
        unset($data['images']);

        $data['user_id'] = $request->user()->id;
        $product = Product::create($data);

        if (!empty($images)) {
            $this->imageService->uploadImages($images, 'products', $product);
        }

        return redirect()->route('merchant.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        abort_unless($product->user_id === auth()->id(), 403);
        $product->load('images');

        return view('merchant.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $images = $data['images'] ?? [];
        unset($data['images']);

        $product->update($data);

        if (!empty($images)) {
            $this->imageService->uploadImages($images, 'products', $product);
        }

        return redirect()->route('merchant.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        abort_unless($product->user_id === auth()->id(), 403);

        $this->imageService->deleteAllImages($product);
        $product->delete();

        return redirect()->route('merchant.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
