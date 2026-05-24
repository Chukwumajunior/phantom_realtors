<?php

namespace App\Enums;

enum PropertyCategory: string
{
    case Residential = 'residential';
    case Commercial = 'commercial';
    case Land = 'land';
    case Building = 'building';

    public function label(): string
    {
        return match ($this) {
            self::Residential => 'Residential',
            self::Commercial => 'Commercial',
            self::Land => 'Land',
            self::Building => 'Building',
        };
    }
}
