<?php

namespace App\Livewire\Merchant;

use App\Models\Product;
use App\Services\ImageService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ProductList extends Component
{
    use WithPagination;

    public string $notification = '';
    public string $notificationType = 'success';

    public function deleteProduct(int $id): void
    {
        $product = Product::findOrFail($id);

        abort_unless($product->user_id === auth()->id(), 403);

        $imageService = app(ImageService::class);
        $imageService->deleteAllImages($product);
        $product->delete();

        $this->notification = 'Product deleted successfully.';
        $this->notificationType = 'success';
    }

    public function render()
    {
        $products = auth()->user()->products()
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('livewire.merchant.product-list', compact('products'))
            ->title('My Products');
    }
}
