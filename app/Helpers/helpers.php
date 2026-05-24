<?php

use App\Enums\Currency;

if (! function_exists('format_price')) {
    /**
     * Format a price with the appropriate currency symbol.
     *
     * @param  float|int|string  $amount
     * @param  Currency|string|null  $currency  Specific currency, or null for system default
     * @param  int  $decimals  Number of decimal places
     */
    function format_price(float|int|string $amount, Currency|string|null $currency = null, int $decimals = 2): string
    {
        if ($currency instanceof Currency) {
            $curr = $currency;
        } elseif (is_string($currency)) {
            $curr = Currency::tryFrom($currency) ?? default_currency();
        } else {
            $curr = default_currency();
        }

        return $curr->symbol() . ' ' . number_format((float) $amount, $decimals);
    }
}

if (! function_exists('default_currency')) {
    /**
     * Get the system's default currency.
     */
    function default_currency(): Currency
    {
        return Currency::from(config('app.currency', 'NGN'));
    }
}
