<?php

namespace App\Transformers;

use App\CarUnlisted;
use League\Fractal\TransformerAbstract;

/**
 * Class CarUnlistedTransformer
 * @package App\Transformers
 */
class CarUnlistedTransformer extends TransformerAbstract
{

	/**
	 * @param CarUnlisted $carUnlisted
	 *
	 * @return array
	 */
	public function transform(CarUnlisted $carUnlisted)
    {
        return [
	        'carId' => (int)$carUnlisted->car_id,
	        'car_status' => (string)$carUnlisted->car_status,
	        'haveNoCar' => isset($carUnlisted->have_no_car) ? (boolean)$carUnlisted->have_no_car : null,
	        'safetyConcerns' => isset($carUnlisted->safety_concerns) ? (boolean)$carUnlisted->safety_concerns : null,
	        'notEarningEnough' => isset($carUnlisted->not_earning_enough) ? (boolean)$carUnlisted->not_earning_enough : null,
	        'tooMuchWork' => isset($carUnlisted->too_much_work) ? (boolean)$carUnlisted->too_much_work : null,
	        'negativeExperience' => isset($carUnlisted->negative_experience) ? (boolean)$carUnlisted->negative_experience : null,
	        'otherReason' => isset($carUnlisted->other_reason) ? (boolean)$carUnlisted->other_reason : null,
	        'startDate' => isset($carUnlisted->start_date) ? (string)$carUnlisted->start_date : null,
	        'endDate' => isset($carUnlisted->end_date) ? (string)$carUnlisted->end_date : null,
	        'feedback' => isset($carUnlisted->feedback) ? (string)$carUnlisted->feedback : null,
        ];
    }
}
