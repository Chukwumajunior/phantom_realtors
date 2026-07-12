<?php

namespace App\Enums;

use App\Models\SiteConfig;

enum PosterTier: string
{
    case Tier1 = 'tier_1';
    case Tier2 = 'tier_2';
    case Tier3 = 'tier_3';

    public function label(): string
    {
        return match ($this) {
            self::Tier1 => 'Tier 1 - Basic',
            self::Tier2 => 'Tier 2 - Standard',
            self::Tier3 => 'Tier 3 - Unlimited',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Tier1 => '1 post in 1 category. Perfect for getting started.',
            self::Tier2 => 'Up to 3 posts across 3 categories. Great for growing businesses.',
            self::Tier3 => 'Unlimited posts and categories. For established businesses.',
        };
    }

    public function maxPosts(): ?int
    {
        return match ($this) {
            self::Tier1 => 1,
            self::Tier2 => 3,
            self::Tier3 => null,
        };
    }

    public function maxCategories(): ?int
    {
        return match ($this) {
            self::Tier1 => 1,
            self::Tier2 => 3,
            self::Tier3 => null,
        };
    }

    public function isFree(): bool
    {
        return $this === self::Tier1;
    }

    public function price(): int
    {
        return SiteConfig::getTierPrice($this->value);
    }

    public function requiresCac(): bool
    {
        return $this === self::Tier3;
    }

    public function requiresCompanyName(): bool
    {
        return $this === self::Tier3;
    }

    public function color(): string
    {
        return match ($this) {
            self::Tier1 => 'gray',
            self::Tier2 => 'blue',
            self::Tier3 => 'purple',
        };
    }
}
