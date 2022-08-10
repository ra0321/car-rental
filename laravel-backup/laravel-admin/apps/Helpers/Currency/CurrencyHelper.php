<?php

namespace App\Helpers\Currency;

use App\Currency;

class CurrencyHelper
{
    /**
     * @param $value
     * @return float|int
     */
    public static function exchange($value)
    {
        $exchangeRate = Currency::where('country_currency_id', self::getCurrencyType())
                        ->orderBy('id', 'desc')
                        ->first();

        if(!$exchangeRate) {
            return ceil($value);
        }
        return ceil($value * $exchangeRate->conversion);
    }

    /**
     * @return int|string|null
     * 101 is default value for Saudi Arabia currency - SAR
     */
    private static function getCurrencyType()
    {
        return (int)request()->headers->get('Currency');
    }
}