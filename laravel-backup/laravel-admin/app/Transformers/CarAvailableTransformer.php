<?php

namespace App\Transformers;

use App\CarAvailable;
use League\Fractal\TransformerAbstract;

/**
 * Class CarAvailableTransformer
 * @package App\Transformers
 */
class CarAvailableTransformer extends TransformerAbstract
{

    /**
     * @param CarAvailable $carAvailable
     * @return array
     */
    public function transform(CarAvailable $carAvailable)
    {
        return [
	        'id' => (int)$carAvailable->id,
	        'carId' => (int)$carAvailable->car_id,
	        'tripId' => isset($carAvailable->trip_id) ? (int)$carAvailable->trip_id : null,
	        'carUnavailableFrom' => (string)$carAvailable->unavailable_from,
	        'carUnavailableTo' => (string)$carAvailable->unavailable_to,
        ];
    }
}
