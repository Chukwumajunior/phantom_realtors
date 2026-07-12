<?php

namespace App\Livewire\Admin;

use App\Models\Banner;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class BannerManagement extends Component
{
    use WithFileUploads;

    public string $notification = '';
    public string $notificationType = '';

    // New banner form
    public string $title = '';
    public $media = null;
    public string $link_url = '';
    public int $sort_order = 0;

    // Edit mode
    public ?int $editingId = null;
    public string $editTitle = '';
    public string $editLinkUrl = '';
    public int $editSortOrder = 0;
    public $editMedia = null;

    public function addBanner(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'media' => ['required', 'file', 'max:51200', 'mimes:jpg,jpeg,png,webp,gif,mp4,webm'],
            'link_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $extension = $this->media->getClientOriginalExtension();
        $mediaType = match (strtolower($extension)) {
            'gif' => 'gif',
            'mp4', 'webm' => 'video',
            default => 'image',
        };

        $path = $this->media->store('banners', 'public');

        // Shift existing banners down if sort_order conflicts
        Banner::where('sort_order', '>=', $this->sort_order)
            ->increment('sort_order');

        Banner::create([
            'title' => $this->title,
            'media_path' => $path,
            'media_type' => $mediaType,
            'link_url' => $this->link_url ?: null,
            'is_active' => true,
            'sort_order' => $this->sort_order,
        ]);

        $this->reset(['title', 'media', 'link_url']);
        $this->sort_order = 0;
        $this->notification = 'Banner added successfully.';
        $this->notificationType = 'success';
    }

    public function startEdit(int $id): void
    {
        $banner = Banner::findOrFail($id);
        $this->editingId = $id;
        $this->editTitle = $banner->title;
        $this->editLinkUrl = $banner->link_url ?? '';
        $this->editSortOrder = $banner->sort_order;
        $this->editMedia = null;
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editMedia = null;
    }

    public function updateBanner(): void
    {
        $this->validate([
            'editTitle' => ['required', 'string', 'max:255'],
            'editMedia' => ['nullable', 'file', 'max:51200', 'mimes:jpg,jpeg,png,webp,gif,mp4,webm'],
            'editLinkUrl' => ['nullable', 'url', 'max:255'],
            'editSortOrder' => ['required', 'integer', 'min:0'],
        ]);

        $banner = Banner::findOrFail($this->editingId);

        // Shift existing banners down if sort_order conflicts (exclude current banner)
        if ($this->editSortOrder !== $banner->sort_order) {
            Banner::where('sort_order', '>=', $this->editSortOrder)
                ->where('id', '!=', $banner->id)
                ->increment('sort_order');
        }

        $data = [
            'title' => $this->editTitle,
            'link_url' => $this->editLinkUrl ?: null,
            'sort_order' => $this->editSortOrder,
        ];

        if ($this->editMedia) {
            // Delete old file
            $oldPath = storage_path('app/public/' . $banner->media_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $extension = $this->editMedia->getClientOriginalExtension();
            $data['media_type'] = match (strtolower($extension)) {
                'gif' => 'gif',
                'mp4', 'webm' => 'video',
                default => 'image',
            };
            $data['media_path'] = $this->editMedia->store('banners', 'public');
        }

        $banner->update($data);

        $this->editingId = null;
        $this->editMedia = null;
        $this->notification = 'Banner updated successfully.';
        $this->notificationType = 'success';
    }

    public function toggleActive(int $id): void
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => !$banner->is_active]);

        $status = $banner->is_active ? 'activated' : 'deactivated';
        $this->notification = "Banner \"{$banner->title}\" {$status}.";
        $this->notificationType = 'success';
    }

    public function deleteBanner(int $id): void
    {
        $banner = Banner::findOrFail($id);
        $path = storage_path('app/public/' . $banner->media_path);
        if (file_exists($path)) {
            unlink($path);
        }
        $banner->delete();

        $this->notification = 'Banner deleted successfully.';
        $this->notificationType = 'success';
    }

    public function render()
    {
        $banners = Banner::orderBy('sort_order')->get();

        return view('livewire.admin.banner-management', compact('banners'))
            ->title('Banner Management');
    }
}
