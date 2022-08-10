<?php

namespace App\Transformers;

use App\CarRestriction;
use App\Helpers\Currency\CurrencyHelper;
use League\Fractal\TransformerAbstract;

/**
 * Class CarRestrictionTransformer
 * @package App\Transformers
 */
class CarRestrictionTransformer extends TransformerAbstract
{

	/**
	 * @param CarRestriction $carRestriction
	 *
	 * @return array
	 */
	public function transform(CarRestriction $carRestriction)
    {
        return [
            'id' => (int)$carRestriction->id,
	        'carId' => (int)$carRestriction->car_id,
			'kmPerDay' => isset($carRestriction->km_per_day) ? (string)$carRestriction->km_per_day : null,
	        'kmPerWeek' => isset($carRestriction->km_per_week) ? (string)$carRestriction->km_per_week : null,
			'kmPerMonth' => isset($carRestriction->km_per_month) ? (string)$carRestriction->km_per_month : null,
			'pricePerKm' => isset($carRestriction->price_per_km) ? CurrencyHelper::exchange((float)$carRestriction->price_per_km) : null,
        ];
    }
}
