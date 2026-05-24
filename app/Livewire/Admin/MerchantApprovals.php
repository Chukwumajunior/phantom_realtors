<?php

namespace App\Livewire\Admin;

use App\Enums\MerchantStatus;
use App\Models\MerchantProfile;
use Livewire\Component;
use Livewire\WithPagination;

class MerchantApprovals extends Component
{
    use WithPagination;

    public string $filter = 'pending';

    public function approve(int $id)
    {
        $profile = MerchantProfile::findOrFail($id);
        $profile->update([
            'status' => MerchantStatus::Approved,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        session()->flash('success', 'Merchant approved.');
    }

    public function reject(int $id, string $reason = '')
    {
        $profile = MerchantProfile::findOrFail($id);
        $profile->update([
            'status' => MerchantStatus::Rejected,
            'rejection_reason' => $reason,
        ]);

        session()->flash('success', 'Merchant rejected.');
    }

    public function render()
    {
        $merchants = MerchantProfile::with('user')
            ->when($this->filter !== 'all', fn($q) => $q->where('status', $this->filter))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.merchant-approvals', compact('merchants'));
    }
}
