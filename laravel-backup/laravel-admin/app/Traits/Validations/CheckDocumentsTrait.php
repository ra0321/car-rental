<?php


namespace App\Traits\Validations;


use App\CarInsurance;
use App\Exceptions\CustomException;

/**
 * Trait CheckDocumentsTrait
 * @package App\Traits\Validations
 */
trait CheckDocumentsTrait {

	/**
	 * @param $insurance
	 *
	 * @throws CustomException
	 */
	public function checkCarInsuranceExpired($insurance)
	{
		if($insurance['expired']){
			throw new CustomException(CAR_INSURANCE_EXPIRED);
		}
	}

    /**
     * @param $data
     * @throws CustomException
     */
    public function isCarInsuranceExpired($data)
    {
        $insurance = CarInsurance::whereCarId($data['car']->id)->firstOrFail();
        if($insurance['expired']){
            throw new CustomException(CAR_INSURANCE_EXPIRED);
        }
    }

	/**
	 * @param $profile
	 *
	 * @throws CustomException
	 */
	public function checkDriverLicenceExpired($profile)
	{
		if($profile['expired_dl']){
			throw new CustomException(YOUR_DRIVER_LICENCE_IS_EXPIRED);
		}
	}

	/**
	 * @param $profile
	 *
	 * @throws CustomException
	 */
	public function checkIdCardExpired($profile)
	{
		if($profile['expired_id']){
			throw new CustomException(YOUR_ID_CARD_IS_EXPIRED);
		}
	}
}
