<?php

namespace App\Livewire\Merchant;

use App\Models\Property;
use App\Services\ImageService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PropertyList extends Component
{
    use WithPagination;

    public string $notification = '';
    public string $notificationType = 'success';

    public function deleteProperty(int $id): void
    {
        $property = Property::findOrFail($id);

        abort_unless($property->user_id === auth()->id(), 403);

        $imageService = app(ImageService::class);
        $imageService->deleteAllImages($property);
        $property->delete();

        $this->notification = 'Property deleted successfully.';
        $this->notificationType = 'success';
    }

    public function render()
    {
        $properties = auth()->user()->properties()
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('livewire.merchant.property-list', compact('properties'))
            ->title('My Properties');
    }
}
