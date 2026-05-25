<?php

namespace App\Livewire;

use App\Enums\PropertyCategory;
use App\Enums\PropertyType;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyListings extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';
    public string $category = '';
    public string $country = '';
    public string $state = '';
    public string $city = '';
    public string|float|null $minPrice = null;
    public string|float|null $maxPrice = null;
    public string $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'category' => ['except' => ''],
        'country' => ['except' => ''],
        'state' => ['except' => ''],
        'city' => ['except' => ''],
        'minPrice' => ['except' => null],
        'maxPrice' => ['except' => null],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingCountry()
    {
        $this->state = '';
        $this->city = '';
        $this->resetPage();
    }

    public function updatingState()
    {
        $this->city = '';
        $this->resetPage();
    }

    public function updatingCity()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'type', 'category', 'country', 'state', 'city', 'minPrice', 'maxPrice', 'sortBy']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Property::publiclyVisible()->with('images');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhere('address', 'like', "%{$this->search}%")
                  ->orWhere('city', 'like', "%{$this->search}%");
            });
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->country) {
            $query->where('country', $this->country);
        }

        if ($this->state) {
            $query->where('state', $this->state);
        }

        if ($this->city) {
            $query->where('city', $this->city);
        }

        if ($this->minPrice !== null && $this->minPrice !== '') {
            $query->where('price', '>=', (float) $this->minPrice);
        }

        if ($this->maxPrice !== null && $this->maxPrice !== '') {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        $query = match ($this->sortBy) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $countries = Property::publiclyVisible()
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        $states = collect();
        if ($this->country) {
            $states = Property::publiclyVisible()
                ->where('country', $this->country)
                ->whereNotNull('state')
                ->where('state', '!=', '')
                ->distinct()
                ->orderBy('state')
                ->pluck('state');
        }

        $cities = collect();
        if ($this->state) {
            $cities = Property::publiclyVisible()
                ->where('state', $this->state)
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->distinct()
                ->orderBy('city')
                ->pluck('city');
        }

        return view('livewire.property-listings', [
            'properties' => $query->paginate(12),
            'types' => PropertyType::cases(),
            'categories' => PropertyCategory::cases(),
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        ]);
    }
}
