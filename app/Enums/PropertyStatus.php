<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Available = 'available';
    case Sold = 'sold';
    case Leased = 'leased';
    case Rented = 'rented';
    case Unavailable = 'unavailable';

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Sold => 'Sold',
            self::Leased => 'Leased',
            self::Rented => 'Rented',
            self::Unavailable => 'Unavailable',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Available => 'green',
            self::Sold => 'blue',
            self::Leased => 'indigo',
            self::Rented => 'purple',
            self::Unavailable => 'red',
        };
    }
}
