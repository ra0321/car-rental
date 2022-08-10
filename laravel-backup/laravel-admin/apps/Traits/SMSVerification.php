<?php

namespace App\Traits;

use App\Exceptions\CustomException;
use Authy\AuthyApi;

/**
 * Trait SMSVerification
 * @package App\Traits
 */
trait SMSVerification
{
	/**
	 * @param $user
	 *
	 * @return \Authy\AuthyUser
	 */
	public function registerPhone($user)
	{
		$authy_api = new AuthyApi(getenv('AUTHY_API_KEY'));
		$user_authy = $authy_api->registerUser($user->email, $user->phone_number, $user->country_code);
		return $user_authy;
	}
	/**
	 * @param $user
	 *
	 * @return \Authy\AuthyResponse
	 */
	public function verifySMS($user)
	{
		$authy_api = new AuthyApi(getenv('AUTHY_API_KEY'));
		$verification = $authy_api->verifyToken($user->authy_id, $user->sms_token);
		return $verification;
	}

    /**
     * @param $authy_id
     * @return \Authy\AuthyResponse
     * @throws CustomException
     */
    public function sendSMS($authy_id)
	{
		$authy_api = new AuthyApi(getenv('AUTHY_API_KEY'));
		$sms = $authy_api->requestSms($authy_id);

		if($sms->ok()){
			return $sms;
		}else{
            throw new CustomException(SOMETHING_WRONG_WITH_SMS);
		}
	}
}