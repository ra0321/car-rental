<?php

namespace App\Transformers;

use App\BookInstantly;
use App\Helpers\Currency\CurrencyHelper;
use League\Fractal\TransformerAbstract;

/**
 * Class BookInstantlyTransformer
 * @package App\Transformers
 */
class BookInstantlyTransformer extends TransformerAbstract
{
	/**
	 * @param BookInstantly $bookInstantly
	 *
	 * @return array
	 */
	public function transform(BookInstantly $bookInstantly)
    {
        return [
	        'carId' => (int)$bookInstantly->car_id,
	        'onCarLocation' => (boolean)$bookInstantly->on_car_location,
	        'onAirport' => (boolean)$bookInstantly->on_airport,
	        'onGuestLocation' => (boolean)$bookInstantly->on_guest_location,
	        'workOnGuestLocation' => (boolean)$bookInstantly->work_on_guest_location,
            'deliveryFeeGuestLocation' => isset($bookInstantly->delivery_fee_guest_location) ? CurrencyHelper::exchange((int)$bookInstantly->delivery_fee_guest_location) : null,
            'maxDistance' => isset($bookInstantly->max_distance) ? (int)$bookInstantly->max_distance : null,
            'minTripForFreeDelivery' => isset($bookInstantly->min_trip_for_free_delivery) ? (int)$bookInstantly->min_trip_for_free_delivery : null,
            'guestLocationDeliveryDetails' => isset($bookInstantly->guest_location_delivery_details) ? (string)$bookInstantly->guest_location_delivery_details : null,
        ];
    }
}
