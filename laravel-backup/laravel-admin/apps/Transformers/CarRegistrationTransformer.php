<?php

namespace App\Transformers;

use App\CarRegistration;
use League\Fractal\TransformerAbstract;

/**
 * Class CarRegistrationTransformer
 * @package App\Transformers
 */
class CarRegistrationTransformer extends TransformerAbstract
{

	/**
	 * @param CarRegistration $carRegistration
	 *
	 * @return array
	 */
	public function transform(CarRegistration $carRegistration)
    {
        return [
        	'id' => (int)$carRegistration->id,
	        'carId' => (int)$carRegistration->car_id,
	        'carCity' => (string)$carRegistration->city,
	        'licencePlate' => (string)$carRegistration->licence_plate,
	        'country' => (string)$carRegistration->country,
			'state' => (string)$carRegistration->state,
			'city' => (string)$carRegistration->city,
			'expirationDate' => (string)$carRegistration->expiration_date,
			'dateOfIssue' => (string)$carRegistration->date_of_issue,
			'smallCarRegistrationImage' => (string)$carRegistration->small_car_registration_image,
			'carRegistrationImage' => (string)$carRegistration->original_car_registration_image,
        ];
    }
}
