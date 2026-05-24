<?php

namespace App\Enums;

enum ServiceCategory: string
{
    case Painting = 'painting';
    case Installation = 'installation';
    case WeldingIronworks = 'welding_ironworks';
    case WaterBorehole = 'water_borehole';
    case Roofing = 'roofing';
    case CarpentryWoodwork = 'carpentry_woodwork';
    case Cleaning = 'cleaning';
    case Renovation = 'renovation';

    public function label(): string
    {
        return match ($this) {
            self::Painting => 'Painting',
            self::Installation => 'Installation',
            self::WeldingIronworks => 'Welding & Ironworks',
            self::WaterBorehole => 'Water Borehole',
            self::Roofing => 'Roofing',
            self::CarpentryWoodwork => 'Carpentry & Woodwork',
            self::Cleaning => 'Cleaning',
            self::Renovation => 'Renovation',
        };
    }
}
