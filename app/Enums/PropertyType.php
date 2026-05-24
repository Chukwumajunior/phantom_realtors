<?php

namespace App\Enums;

enum PropertyType: string
{
    case Sale = 'sale';
    case Lease = 'lease';
    case Rent = 'rent';
    case ShortLet = 'short_let';

    public function label(): string
    {
        return match ($this) {
            self::Sale => 'For Sale',
            self::Lease => 'For Lease',
            self::Rent => 'For Rent',
            self::ShortLet => 'Short Let',
        };
    }
}
