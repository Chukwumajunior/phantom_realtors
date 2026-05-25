<?php

namespace App\Livewire;

use App\Enums\ServiceCategory;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceListings extends Component
{
    use WithPagination;

    public string $search = '';
    public string $category = '';
    public string $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'category', 'sortBy']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Service::publiclyVisible()->with('images');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhere('service_area', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        $query = match ($this->sortBy) {
            'price_asc' => $query->orderBy('price_from', 'asc'),
            'price_desc' => $query->orderBy('price_from', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return view('livewire.service-listings', [
            'services' => $query->paginate(12),
            'categories' => ServiceCategory::cases(),
        ]);
    }
}
