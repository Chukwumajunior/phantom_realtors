<?php

namespace App\Enums;

enum Currency: string
{
    case NGN = 'NGN';
    case USD = 'USD';
    case GBP = 'GBP';
    case EUR = 'EUR';
    case GHS = 'GHS';
    case KES = 'KES';
    case ZAR = 'ZAR';

    public function symbol(): string
    {
        return match ($this) {
            self::NGN => "\u{20A6}",
            self::USD => '$',
            self::GBP => "\u{00A3}",
            self::EUR => "\u{20AC}",
            self::GHS => "GH\u{20B5}",
            self::KES => 'KSh',
            self::ZAR => 'R',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::NGN => 'Nigerian Naira',
            self::USD => 'US Dollar',
            self::GBP => 'British Pound',
            self::EUR => 'Euro',
            self::GHS => 'Ghanaian Cedi',
            self::KES => 'Kenyan Shilling',
            self::ZAR => 'South African Rand',
        };
    }
}
