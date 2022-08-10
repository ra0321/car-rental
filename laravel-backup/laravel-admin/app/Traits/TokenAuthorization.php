<?php

namespace App\Traits;

use App\Exceptions\CustomException;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

/**
 * Trait TokenAuthorization
 * @package App\Traits
 */
trait TokenAuthorization
{
	/**
	 * @param $credentials
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function authorizeUser($credentials) {

		try {
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 500);
		}
        return response()->json(compact('token'));
	}

    /**
     * @return mixed
     * @throws CustomException
     */
    public function authenticateUserByToken()
	{
		if($user = JWTAuth::parseToken()->authenticate()){
			return $user;
		}
        throw new CustomException(TOKEN_INVALID);
	}

    /**
     * @param $id
     * @return mixed
     * @throws CustomException
     */
    public function authenticateUserById($id)
	{
		if(!$user = JWTAuth::parseToken()->authenticate()){
            throw new CustomException(TOKEN_INVALID);
		}elseif ($user->id != $id){
            throw new CustomException(DOES_NOT_EXIST_MODEL_WITH_THIS_ID);
		}
		return $id;
	}

    /**
     * @param $user
     * @return string
     */
    public function createTokenForSocialNetworkUser($user)
    {
        return JWTAuth::fromUser($user);
    }

	/**
	 * @param $credentials
	 *
	 * @return mixed
	 */
	public function tokenValue($credentials)
	{
		$token = $this->authorizeUser($credentials);
		return $token->getData()->token;
	}

    /**
     * @param $userId
     * @param $model
     * @throws CustomException
     */
    public function checkUser($userId, $model)
    {
        if($model->user_id != $userId){
            throw new CustomException(THE_SPECIFIED_USER_IS_NOT_A_OWNER_OF_THIS_CAR);
        }
    }

    /**
     * @param $userId
     * @param $trip
     * @throws CustomException
     */
    public function checkTripCarOwner($userId, $trip)
    {
        if($trip->owner_id != $userId){
            throw new CustomException(THE_SPECIFIED_USER_IS_NOT_A_RELATED_WITH_THIS_TRIP);
        }
    }

    /**
     * @param $userId
     * @param $trip
     * @throws CustomException
     */
    public function checkTripCarRenter($userId, $trip)
    {
        if($trip->renter_id != $userId){
            throw new CustomException(THE_SPECIFIED_USER_IS_NOT_A_RELATED_WITH_THIS_TRIP);
        }
    }

    /**
     * @param $tripId
     * @param $activityRequest
     * @throws CustomException
     */
    public function checkTripActivity($tripId, $activityRequest)
    {
        if($activityRequest->trip_id != $tripId){
            throw new CustomException(THE_SPECIFIED_TRIP_IS_NOT_RELATED_WITH_THIS_NOTIFICATION);
        }
    }

    /**
     * @param $userId
     * @param $trip
     * @throws CustomException
     */
    public function checkUserTrip($userId, $trip)
    {
        if($trip->owner_id != $userId && $trip->renter_id != $userId){
            throw new CustomException(THE_SPECIFIED_USER_IS_NOT_A_RELATED_WITH_THIS_TRIP);
        }
    }

    /**
     * @return mixed
     */
    /*public function guard()
    {
        return Auth::guard();
    }*/
}