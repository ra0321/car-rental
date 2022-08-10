<?php
namespace App\Traits;

use App\Car;
use App\Exceptions\CustomException;
use App\Profile;
use App\User;
use Carbon\Carbon;

/**
 * Trait CheckDocument
 * @package App\Traits
 */
trait CheckDocument {

	use ValueTransform;
	/**
	 * @param User $user
	 *
	 * @throws CustomException
	 */
	public function checkDriverLicence(User $user)
	{
		$profile = Profile::where('user_id', $user->id)->first();
		$now = Carbon::now();
		$timeForCompare = Carbon::parse($user->created_at)->addHours(48);
		if($profile->driver_licence_number === null){
			throw new CustomException(PLEASE_GO_TO_USER_SETTINGS_AND_ENTER_THE_DATA_OF_YOUR_DRIVER_LICENSE);
		}
		if($timeForCompare->lt($now)){
			if($user->approved_to_drive != true){
				throw new CustomException(SORRY_YOU_CANNOT_RENT_A_CAR_AT_THIS_MOMENT_YOUR_DRIVER_LICENSE_IS_NOT_VERIFIED_TO_VERIFY_YOUR_DRIVER_LICENSE_PLEASE_CALL_90023727);
			}
		}
	}

	/**
	 * @param User $user
	 *
	 * @throws CustomException
	 */
	public function checkId(User $user)
	{
		$profile = Profile::whereUserId($user->id)->first();
		$now = Carbon::now();
		$timeForCompare = Carbon::parse($user->created_at)->addHours(48);
		//if($profile->id_number === null){
		if($profile->expiration_date === null){
			throw new CustomException(PLEASE_GO_TO_OWNER_SETTINGS_PAGE_AND_ENTER_THE_DATA_OF_YOUR_ID_CARD);
		}
		if($timeForCompare->lt($now)){
			if($user->id_verified != true){
				throw new CustomException(SORRY_YOU_CANNOT_RENT_A_CAR_AT_THIS_MOMENT_YOUR_IDENTITY_IS_NOT_VERIFIED_TO_VERIFY_YOUR_IDENTITY_PLEASE_CALL_90023727);
			}
		}
	}

	/**
	 * @param User $user
	 *
	 * @throws CustomException
	 */
	public function isOwnerIdVerified(User $user)
	{
		if($user->id_verified != true){
			throw new CustomException(SORRY_YOU_CANNOT_RENT_THIS_CAR_OWNERS_ID_NEEDS_TO_BE_VERIFIED);
		}
	}

	/**
	 * @param Car $car
	 *
	 * @throws CustomException
	 */
	public function isCarDeleted(Car $car)
	{
		if($car->is_deleted == true){
			throw new CustomException(SORRY_YOU_CANNOT_RENT_THIS_CAR_THIS_CAR_WAS_DELETED);
		}
	}

	/**
	 * @param Car $car
	 *
	 * @throws CustomException
	 */
	public function isCarRegistrationVerified(Car $car)
	{
		if($car->is_registration_car_verified != true){
			throw new CustomException(SORRY_YOU_CANNOT_RENT_THIS_CAR_THIS_CAR_REGISTRATION_IS_NOT_VERIFIED);
		}
	}

	/**
	 * @param Car $car
	 *
	 * @throws CustomException
	 */
	public function isCarInsuranceVerified(Car $car)
	{
		if($car->is_insurance_verified != true){
			throw new CustomException(SORRY_YOU_CANNOT_RENT_THIS_CAR_THIS_CAR_INSURANCE_IS_NOT_VERIFIED);
		}
	}

	/**
	 * @param Car $car
	 * @param $request
	 *
	 * @throws CustomException
	 */
	public function checkAdvanceNotice(Car $car, $request)
	{
		$notice = $this->noticeTransform($car->notice);
		$hours = Carbon::now()->diffInHours(Carbon::parse($request['price_from_date']));
		if($hours < $notice){
			throw new CustomException(SORRY_YOU_CANNOT_RENT_THIS_CAR_THIS_BECAUSE_ADVANCE_NOTICE);
		}
	}
}
