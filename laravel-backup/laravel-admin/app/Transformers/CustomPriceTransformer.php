<?php

namespace App\Transformers;

use App\CustomPrice;
use App\Helpers\Currency\CurrencyHelper;
use League\Fractal\TransformerAbstract;

/**
 * Class CustomPriceTransformer
 * @package App\Transformers
 */
class CustomPriceTransformer extends TransformerAbstract
{

	/**
	 * @param CustomPrice $customPrice
	 *
	 * @return array
	 */
	public function transform(CustomPrice $customPrice)
    {
        return [
	        'id' => (int)$customPrice->id,
	        'carId' => (int)$customPrice->car_id,
            'isAutomaticPrice' => $automathic_price = (boolean)$customPrice->is_automatic_price,
            'price' => isset($customPrice->price) ? CurrencyHelper::exchange((int)$customPrice->price) : null,
            'weeklyDiscount' => isset($customPrice->discount_week) ? $automathic_price ? 15 : (int)$customPrice->discount_week : null,
            'monthlyDiscount' => isset($customPrice->discount_month) ? $automathic_price ? 25 : (int)$customPrice->discount_month : null,
	        'customPrice' => isset($customPrice->custom_price) ? CurrencyHelper::exchange((int)$customPrice->custom_price) : null,
	        'priceFrom' => isset($customPrice->price_from_date) ? (string)$customPrice->price_from_date : null,
	        'priceUntil' => isset($customPrice->price_until_date) ? (string)$customPrice->price_until_date : null,
        ];
    }
}
