<?php

namespace App\Transformers;

use App\CountryCurrency;
use League\Fractal\TransformerAbstract;

/**
 * Class CountryCurrencyTransformer
 * @package App\Transformers
 */
class CountryCurrencyTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * @param CountryCurrency $currency
     * @return array
     */
    public function transform(CountryCurrency $currency)
    {
        return [
            'currencyId' => $currency->id,
            'currencyCountry' => $currency->country,
            'currencyCountryAr' => $currency->arabic_country,
            'currency' => $currency->currency,
            'currencyAr' => $currency->arabic_currency,
            'currencyCode' => $currency->code,
            'currencyCodeAr' => $currency->arabic_code,
            'currencySymbol' => $currency->symbol,
            'currencySymbolAr' => $currency->arabic_symbol
        ];
    }
}
