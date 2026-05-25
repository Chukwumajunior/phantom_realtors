<?php

namespace App\Livewire\Admin;

use App\Models\SiteConfig;
use App\Models\SubscriptionPlan;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class SiteSettings extends Component
{
    public string $notification = '';
    public string $notificationType = '';

    // Bank details
    public string $bank_name = '';
    public string $account_name = '';
    public string $account_number = '';

    // New plan form
    public string $newPlanName = '';
    public string $newPlanPrice = '';
    public string $newPlanDuration = '';
    public string $newPlanDescription = '';
    public bool $newPlanIsPremium = false;

    // Edit plan data (keyed by plan ID)
    public array $planData = [];

    // Featured settings
    public int $maxPerMerchant = 10;
    public int $rotationSeconds = 5;
    public int $propertiesPerPage = 6;
    public int $propertiesPerRow = 3;
    public int $productsPerPage = 8;
    public int $productsPerRow = 4;
    public int $servicesPerPage = 6;
    public int $servicesPerRow = 3;

    public function mount(): void
    {
        $bankDetails = SiteConfig::getBankDetails();
        $this->bank_name = $bankDetails['bank_name'] ?? '';
        $this->account_name = $bankDetails['account_name'] ?? '';
        $this->account_number = $bankDetails['account_number'] ?? '';

        $featuredSettings = SiteConfig::getFeaturedSettings();
        $this->maxPerMerchant = (int) $featuredSettings['max_per_merchant'];
        $this->rotationSeconds = (int) $featuredSettings['rotation_seconds'];
        $this->propertiesPerPage = (int) $featuredSettings['properties_per_page'];
        $this->propertiesPerRow = (int) $featuredSettings['properties_per_row'];
        $this->productsPerPage = (int) $featuredSettings['products_per_page'];
        $this->productsPerRow = (int) $featuredSettings['products_per_row'];
        $this->servicesPerPage = (int) $featuredSettings['services_per_page'];
        $this->servicesPerRow = (int) $featuredSettings['services_per_row'];

        $this->loadPlans();
    }

    protected function loadPlans(): void
    {
        $plans = SubscriptionPlan::orderBy('price')->get();
        $this->planData = [];
        foreach ($plans as $plan) {
            $this->planData[$plan->id] = [
                'name' => $plan->name,
                'price' => $plan->price,
                'duration_days' => $plan->duration_days,
                'description' => $plan->description ?? '',
                'is_active' => $plan->is_active,
                'is_premium' => $plan->is_premium,
            ];
        }
    }

    public function saveBankDetails(): void
    {
        $this->validate([
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
        ]);

        SiteConfig::set('bank_details', [
            'bank_name' => $this->bank_name,
            'account_name' => $this->account_name,
            'account_number' => $this->account_number,
        ]);

        $this->notification = 'Bank details updated successfully.';
        $this->notificationType = 'success';
    }

    public function savePlan(int $planId): void
    {
        $data = $this->planData[$planId] ?? null;

        if (!$data) {
            $this->notification = 'Plan not found.';
            $this->notificationType = 'error';
            return;
        }

        $this->validate([
            "planData.{$planId}.name" => ['required', 'string', 'max:255'],
            "planData.{$planId}.price" => ['required', 'numeric', 'min:0'],
            "planData.{$planId}.duration_days" => ['required', 'integer', 'min:1'],
            "planData.{$planId}.description" => ['nullable', 'string', 'max:1000'],
        ]);

        $plan = SubscriptionPlan::findOrFail($planId);
        $plan->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'duration_days' => $data['duration_days'],
            'description' => $data['description'] ?: null,
            'is_active' => $data['is_active'] ?? true,
            'is_premium' => $data['is_premium'] ?? false,
        ]);

        $this->notification = "Plan \"{$plan->name}\" updated successfully.";
        $this->notificationType = 'success';
    }

    public function addPlan(): void
    {
        $this->validate([
            'newPlanName' => ['required', 'string', 'max:255'],
            'newPlanPrice' => ['required', 'numeric', 'min:0'],
            'newPlanDuration' => ['required', 'integer', 'min:1'],
            'newPlanDescription' => ['nullable', 'string', 'max:1000'],
        ]);

        SubscriptionPlan::create([
            'name' => $this->newPlanName,
            'price' => $this->newPlanPrice,
            'duration_days' => $this->newPlanDuration,
            'description' => $this->newPlanDescription ?: null,
            'is_active' => true,
            'is_premium' => $this->newPlanIsPremium,
        ]);

        $this->newPlanName = '';
        $this->newPlanPrice = '';
        $this->newPlanDuration = '';
        $this->newPlanDescription = '';
        $this->newPlanIsPremium = false;

        $this->loadPlans();
        $this->notification = 'New subscription plan created.';
        $this->notificationType = 'success';
    }

    public function deletePlan(int $planId): void
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        $planName = $plan->name;
        $plan->delete();

        $this->loadPlans();
        $this->notification = "Plan \"{$planName}\" deleted.";
        $this->notificationType = 'success';
    }

    public function saveFeaturedSettings(): void
    {
        $this->validate([
            'maxPerMerchant' => ['required', 'integer', 'min:1', 'max:100'],
            'rotationSeconds' => ['required', 'integer', 'min:1', 'max:120'],
            'propertiesPerPage' => ['required', 'integer', 'min:1', 'max:24'],
            'propertiesPerRow' => ['required', 'integer', 'min:1', 'max:12'],
            'productsPerPage' => ['required', 'integer', 'min:1', 'max:24'],
            'productsPerRow' => ['required', 'integer', 'min:1', 'max:12'],
            'servicesPerPage' => ['required', 'integer', 'min:1', 'max:24'],
            'servicesPerRow' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        SiteConfig::set('featured_settings', [
            'max_per_merchant' => $this->maxPerMerchant,
            'rotation_seconds' => $this->rotationSeconds,
            'properties_per_page' => $this->propertiesPerPage,
            'properties_per_row' => $this->propertiesPerRow,
            'products_per_page' => $this->productsPerPage,
            'products_per_row' => $this->productsPerRow,
            'services_per_page' => $this->servicesPerPage,
            'services_per_row' => $this->servicesPerRow,
        ]);

        $this->notification = 'Featured listings settings updated.';
        $this->notificationType = 'success';
    }

    public function render()
    {
        $plans = SubscriptionPlan::orderBy('price')->get();

        return view('livewire.admin.site-settings', compact('plans'))
            ->title('Site Settings');
    }
}
