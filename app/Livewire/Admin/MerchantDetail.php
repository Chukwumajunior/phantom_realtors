<?php

namespace App\Livewire\Admin;

use App\Enums\MerchantStatus;
use App\Enums\UserRole;
use App\Models\MerchantProfile;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class MerchantDetail extends Component
{
    public MerchantProfile $merchantProfile;
    public string $rejectionReason = '';
    public string $message = '';
    public string $messageType = '';

    // Editable fields
    public bool $editing = false;
    public string $ownerName = '';
    public string $businessName = '';
    public string $businessPhone = '';
    public string $businessDescription = '';

    public function mount(MerchantProfile $merchantProfile): void
    {
        $this->merchantProfile = $merchantProfile->load('user');
        $this->loadEditableFields();
    }

    private function loadEditableFields(): void
    {
        $this->ownerName = $this->merchantProfile->user->name ?? '';
        $this->businessName = $this->merchantProfile->business_name ?? '';
        $this->businessPhone = $this->merchantProfile->business_phone ?? '';
        $this->businessDescription = $this->merchantProfile->business_description ?? '';
    }

    public function toggleEdit(): void
    {
        $this->editing = !$this->editing;
        if ($this->editing) {
            $this->loadEditableFields();
        }
    }

    public function saveMerchant(): void
    {
        $this->validate([
            'ownerName' => 'required|string|max:255',
            'businessName' => 'required|string|max:255',
            'businessPhone' => 'nullable|string|max:20',
            'businessDescription' => 'nullable|string|max:2000',
        ]);

        $this->merchantProfile->user->update([
            'name' => $this->ownerName,
        ]);

        $this->merchantProfile->update([
            'business_name' => $this->businessName,
            'business_phone' => $this->businessPhone,
            'business_description' => $this->businessDescription,
        ]);

        $this->merchantProfile->refresh();
        $this->merchantProfile->load('user');
        $this->editing = false;
        $this->message = 'Merchant details updated successfully.';
        $this->messageType = 'success';
    }

    public function approve(): void
    {
        if (!$this->merchantProfile->isPending()) {
            $this->message = 'This merchant is no longer pending approval.';
            $this->messageType = 'error';
            return;
        }

        $this->merchantProfile->update([
            'status' => MerchantStatus::Approved,
        ]);

        // Ensure user has merchant role
        if ($this->merchantProfile->user->role !== UserRole::Merchant) {
            $this->merchantProfile->user->update(['role' => UserRole::Merchant]);
        }

        $this->merchantProfile->refresh();
        $this->message = "Merchant approved. {$this->merchantProfile->tier->label()} activated successfully.";
        $this->messageType = 'success';
    }

    public function reject(): void
    {
        if (!$this->merchantProfile->isPending()) {
            $this->message = 'This merchant is no longer pending approval.';
            $this->messageType = 'error';
            return;
        }

        if (empty($this->rejectionReason)) {
            $this->message = 'Please provide a rejection reason.';
            $this->messageType = 'error';
            return;
        }

        $this->merchantProfile->update([
            'status' => MerchantStatus::Rejected,
        ]);

        $this->merchantProfile->refresh();
        $this->message = 'Application rejected. Merchant has been notified.';
        $this->messageType = 'success';
        $this->rejectionReason = '';
    }

    public function render()
    {
        return view('livewire.admin.merchant-detail')
            ->title('Merchant Details');
    }
}
