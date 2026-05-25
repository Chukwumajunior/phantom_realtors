<?php

namespace App\Livewire\Merchant;

use App\Models\Service;
use App\Services\ImageService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ServiceList extends Component
{
    use WithPagination;

    public string $notification = '';
    public string $notificationType = 'success';

    public function deleteService(int $id): void
    {
        $service = Service::findOrFail($id);

        abort_unless($service->user_id === auth()->id(), 403);

        $imageService = app(ImageService::class);
        $imageService->deleteAllImages($service);
        $service->delete();

        $this->notification = 'Service deleted successfully.';
        $this->notificationType = 'success';
    }

    public function render()
    {
        $services = auth()->user()->services()
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('livewire.merchant.service-list', compact('services'))
            ->title('My Services');
    }
}
