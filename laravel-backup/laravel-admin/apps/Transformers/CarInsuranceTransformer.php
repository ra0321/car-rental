<?php

namespace App\Transformers;

use App\CarInsurance;
use App\Helpers\Currency\CurrencyHelper;
use League\Fractal\TransformerAbstract;

/**
 * Class CarInsuranceTransformer
 * @package App\Transformers
 */
class CarInsuranceTransformer extends TransformerAbstract
{

	/**
	 * @param CarInsurance $carInsurance
	 *
	 * @return array
	 */
	public function transform(CarInsurance $carInsurance)
    {
        return [
	        'id' => (int)$carInsurance->id,
	        'carId' => (int)$carInsurance->car_id,
	        'policyNumber' => (string)$carInsurance->policy_number,
			'detectableAmount' => (string)CurrencyHelper::exchange((int)$carInsurance->detectable_amount),
			'expirationDate' => (string)$carInsurance->expiration_date,
			'dateOfIssue' => (string)$carInsurance->date_of_issue,
			'imagePolicyCard' => (string)$carInsurance->image_policy_card,
			'smallImagePolicyCard' => (string)$carInsurance->small_image_policy_card,
	        "creationDate" => (string)$carInsurance->created_at,
        ];
    }
}
