<?php

namespace App\Transformers;

use App\ArchivedPrice;
use League\Fractal\TransformerAbstract;

/**
 * Class ArchivedPriceTransformer
 * @package App\Transformers
 */
class ArchivedPriceTransformer extends TransformerAbstract
{
    /**
     * @param ArchivedPrice $archivedPrice
     * @return array
     */
    public function transform(ArchivedPrice $archivedPrice)
    {
        return [
            'id' => (int)$archivedPrice->id,
            'carId' => (int)$archivedPrice->car_id,
            'isAutomaticPrice' => $automathic_price = (boolean)$archivedPrice->is_automatic_price,
            'price' => (int)$archivedPrice->price,
            'weeklyDiscount' => isset($archivedPrice->discount_week) ? $automathic_price ? 15 : (int)$archivedPrice->discount_week : null,
            'monthlyDiscount' => isset($archivedPrice->discount_month) ? $automathic_price ? 25 : (int)$archivedPrice->discount_month : null,
            'customPrice' => isset($archivedPrice->custom_price) ? (int)$archivedPrice->custom_price : null,
            'priceFrom' => isset($archivedPrice->price_from_date) ? (string)$archivedPrice->price_from_date : null,
            'priceUntil' => isset($archivedPrice->price_until_date) ? (string)$archivedPrice->price_until_date : null,
            'creationDate' => isset($archivedPrice->price_until_date) ? (string)$archivedPrice->price_until_date : null,
            'archiveDate' => (string)$archivedPrice->created_at,
        ];
    }
}
