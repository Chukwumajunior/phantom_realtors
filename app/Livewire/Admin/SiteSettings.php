<?php

namespace App\Livewire\Admin;

use App\Models\SiteConfig;
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

    // Tier pricing
    public string $tier2Price = '';
    public string $tier3Price = '';

    // Tier descriptions
    public string $tier1Name = '';
    public int $tier1Posts = 1;
    public int $tier1Categories = 1;
    public string $tier1Description = '';

    public string $tier2Name = '';
    public int $tier2Posts = 3;
    public int $tier2Categories = 3;
    public string $tier2Description = '';

    public string $tier3Name = '';
    public string $tier3Description = '';

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

        $tierSettings = SiteConfig::getTierSettings();
        $this->tier2Price = (string) ($tierSettings['tier_2_price'] ?? 10000);
        $this->tier3Price = (string) ($tierSettings['tier_3_price'] ?? 25000);

        $this->tier1Name = $tierSettings['tier_1']['name'] ?? 'Tier 1 - Basic';
        $this->tier1Posts = (int) ($tierSettings['tier_1']['posts'] ?? 1);
        $this->tier1Categories = (int) ($tierSettings['tier_1']['categories'] ?? 1);
        $this->tier1Description = $tierSettings['tier_1']['description'] ?? '';

        $this->tier2Name = $tierSettings['tier_2']['name'] ?? 'Tier 2 - Standard';
        $this->tier2Posts = (int) ($tierSettings['tier_2']['posts'] ?? 3);
        $this->tier2Categories = (int) ($tierSettings['tier_2']['categories'] ?? 3);
        $this->tier2Description = $tierSettings['tier_2']['description'] ?? '';

        $this->tier3Name = $tierSettings['tier_3']['name'] ?? 'Tier 3 - Unlimited';
        $this->tier3Description = $tierSettings['tier_3']['description'] ?? '';

        $featuredSettings = SiteConfig::getFeaturedSettings();
        $this->maxPerMerchant = (int) $featuredSettings['max_per_merchant'];
        $this->rotationSeconds = (int) $featuredSettings['rotation_seconds'];
        $this->propertiesPerPage = (int) $featuredSettings['properties_per_page'];
        $this->propertiesPerRow = (int) $featuredSettings['properties_per_row'];
        $this->productsPerPage = (int) $featuredSettings['products_per_page'];
        $this->productsPerRow = (int) $featuredSettings['products_per_row'];
        $this->servicesPerPage = (int) $featuredSettings['services_per_page'];
        $this->servicesPerRow = (int) $featuredSettings['services_per_row'];
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

    public function saveTierSettings(): void
    {
        $this->validate([
            'tier2Price' => ['required', 'numeric', 'min:0'],
            'tier3Price' => ['required', 'numeric', 'min:0'],
            'tier1Name' => ['required', 'string', 'max:100'],
            'tier1Posts' => ['required', 'integer', 'min:1', 'max:100'],
            'tier1Categories' => ['required', 'integer', 'min:1', 'max:100'],
            'tier1Description' => ['required', 'string', 'max:500'],
            'tier2Name' => ['required', 'string', 'max:100'],
            'tier2Posts' => ['required', 'integer', 'min:1', 'max:100'],
            'tier2Categories' => ['required', 'integer', 'min:1', 'max:100'],
            'tier2Description' => ['required', 'string', 'max:500'],
            'tier3Name' => ['required', 'string', 'max:100'],
            'tier3Description' => ['required', 'string', 'max:500'],
        ]);

        SiteConfig::set('tier_settings', [
            'tier_2_price' => (int) $this->tier2Price,
            'tier_3_price' => (int) $this->tier3Price,
            'tier_1' => [
                'name' => $this->tier1Name,
                'posts' => $this->tier1Posts,
                'categories' => $this->tier1Categories,
                'description' => $this->tier1Description,
            ],
            'tier_2' => [
                'name' => $this->tier2Name,
                'posts' => $this->tier2Posts,
                'categories' => $this->tier2Categories,
                'description' => $this->tier2Description,
            ],
            'tier_3' => [
                'name' => $this->tier3Name,
                'posts' => null,
                'categories' => null,
                'description' => $this->tier3Description,
            ],
        ]);

        $this->notification = 'Tier settings updated successfully.';
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
        return view('livewire.admin.site-settings')
            ->title('Site Settings');
    }
}
