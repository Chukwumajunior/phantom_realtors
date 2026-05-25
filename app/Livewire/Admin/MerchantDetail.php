<?php

namespace App\Livewire\Admin;

use App\Enums\MerchantStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use App\Models\MerchantProfile;
use App\Models\Subscription;
use App\Notifications\MerchantApprovedNotification;
use App\Notifications\MerchantRevisionRequested;
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
    public string $businessAddress = '';
    public string $businessDescription = '';

    public function mount(MerchantProfile $merchantProfile): void
    {
        $this->merchantProfile = $merchantProfile->load('user', 'subscriptionPlan');
        $this->loadEditableFields();
    }

    private function loadEditableFields(): void
    {
        $this->ownerName = $this->merchantProfile->user->name ?? '';
        $this->businessName = $this->merchantProfile->business_name ?? '';
        $this->businessPhone = $this->merchantProfile->business_phone ?? '';
        $this->businessAddress = $this->merchantProfile->business_address ?? '';
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
            'businessAddress' => 'nullable|string|max:500',
            'businessDescription' => 'nullable|string|max:2000',
        ]);

        $this->merchantProfile->user->update([
            'name' => $this->ownerName,
        ]);

        $this->merchantProfile->update([
            'business_name' => $this->businessName,
            'business_phone' => $this->businessPhone,
            'business_address' => $this->businessAddress,
            'business_description' => $this->businessDescription,
        ]);

        $this->merchantProfile->refresh();
        $this->merchantProfile->load('user', 'subscriptionPlan');
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
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        // Change user role to merchant upon approval
        $this->merchantProfile->user->update(['role' => UserRole::Merchant]);

        // Activate the subscription based on the plan they paid for at registration
        $subscription = null;
        if ($this->merchantProfile->subscription_plan_id) {
            $plan = $this->merchantProfile->subscriptionPlan;

            // Expire any existing subscriptions
            $this->merchantProfile->user->subscriptions()
                ->active()
                ->update(['status' => SubscriptionStatus::Expired->value]);

            $subscription = Subscription::create([
                'user_id' => $this->merchantProfile->user_id,
                'subscription_plan_id' => $plan->id,
                'status' => SubscriptionStatus::Active,
                'starts_at' => now(),
                'expires_at' => now()->addDays($plan->duration_days),
                'activated_at' => now(),
                'activated_by' => auth()->id(),
            ]);
        }

        try {
            $this->merchantProfile->user->notify(new MerchantApprovedNotification($subscription));
        } catch (\Exception $e) {
            Log::warning('Failed to send merchant approval email: ' . $e->getMessage());
        }

        $this->merchantProfile->refresh();
        $this->message = "Merchant approved successfully. Subscription activated ({$subscription?->plan?->name}).";
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
            'rejection_reason' => $this->rejectionReason,
        ]);

        try {
            $this->merchantProfile->user->notify(new MerchantRevisionRequested($this->rejectionReason));
        } catch (\Exception $e) {
            Log::warning('Failed to send merchant rejection email: ' . $e->getMessage());
        }

        $this->merchantProfile->refresh();
        $this->message = 'Revision requested. Merchant has been notified.';
        $this->messageType = 'success';
        $this->rejectionReason = '';
    }

    public function render()
    {
        return view('livewire.admin.merchant-detail')
            ->title('Merchant Details');
    }
}
