<?php

namespace App\Livewire\Admin;

use App\Enums\MerchantStatus;
use App\Models\MerchantProfile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class MerchantList extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $status = 'approved';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $merchants = MerchantProfile::with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('business_name', 'like', "%{$this->search}%")
                      ->orWhereHas('user', function ($uq) {
                          $uq->where('name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%");
                      });
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(15);

        $statuses = MerchantStatus::cases();

        return view('livewire.admin.merchant-list', compact('merchants', 'statuses'))
            ->title('Merchants');
    }
}
