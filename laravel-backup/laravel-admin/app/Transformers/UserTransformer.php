<?php

namespace App\Transformers;

use App\CountryCurrency;
use App\Currency;
use App\DriverLicence;
use App\Helpers\Currency\CurrencyHelper;
use App\ID_Card;
use App\User;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Transformers
 */
class UserTransformer extends TransformerAbstract
{
	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'profile', 'social', 'IdCard', 'DriverLicenceCard', 'favoriteCar', 'recentlyViewedCar'
	];

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	public function transform(User $user)
    {
        $fractal = new Manager();
        $currency = CountryCurrency::find($user->currency_type);

        if (isset($_POST['include'])) {
            $fractal->parseIncludes($_POST['include']);
        }
        return [
	        "id"                        => (int)$user->id,
	        "firstName"                 => (string)$user->first_name,
	        "lastName"                  => isset($user->last_name) ? (string)$user->last_name : null,
	        "email"                     => isset($user->email) ? (string)$user->email : null,
	        "countryCode"               => isset($user->country_code) ? (string)$user->country_code : null,
	        "phoneNumber"               => isset($user->phone_number) ? (string)$user->phone_number : null,
	        "isApprovedToDrive"         => isset($user->approved_to_drive) ? (boolean)$user->approved_to_drive : false,
	        "isVerifiedPhone"           => isset($user->phone_verified) ? (boolean)$user->phone_verified : false,
	        "isVerifiedEmail"           => isset($user->email_verified) ? (boolean)$user->email_verified : false,
	        "isIdVerified"              => isset($user->id_verified) ? (boolean)$user->id_verified : false,
            "facebookConnection"        => isset($user->is_facebook) ? (boolean)$user->is_facebook : false,
	        "friendsCount"              => isset($user->friends_count) ? (int)$user->friends_count : null,
	        "googleConnection"          => isset($user->is_google) ? (boolean)$user->is_google : false,
	        "listedCars"                => (integer)$user->listed,
	        "reviewNumberAsRenter"      => (integer)$user->reviewed,
	        "reviewNumberAsOwner"       => (integer)$user->reviewed_as_owner,
	        "userStars"                 => (float)$user->user_stars,
	        "tripsNumber"               => (integer)$user->trips,
	        "carTripsNumber"            => (integer)$user->car_trips,
            "receiveSmsNotifications"   => isset($user->sms_notifications) ? (boolean)$user->sms_notifications : true,
	        "receiveEmailPromotions"    => isset($user->email_promotions) ? (boolean)$user->email_promotions : true,
	        "isTransmissionExpert"      => isset($user->transmission_expert) ? (boolean)$user->transmission_expert : false,
            "workFromTime"              => isset($user->work_from_time) ? (string)$user->work_from_time : null,
            "workUntilTime"             => isset($user->work_until_time) ? (string)$user->work_until_time : null,
            "isWorkingTime"             => isset($user->is_working_time) ? (boolean)$user->is_working_time : false,
	        "payment"                   => isset($user->payment) ? (boolean)$user->payment : null,
	        "bankName"                  => isset($user->bank_name) ? (string)$user->bank_name : null,
	        "holderFullName"            => isset($user->holder_name) ? (string)$user->holder_name : null,
	        "iban"                      => isset($user->iban) ? (string)$user->iban : null,
	        "accountNumber"             => isset($user->account_number) ? (string)$user->account_number : null,
            "isBankAccount"             => isset($user->is_bank_account) ? (boolean)$user->is_bank_account : false,
	        "isUserActive"              => isset($user->user_active_status) ? (boolean)$user->user_active_status : true,
	        "creationDate"              => (string)$user->created_at,
	        "lastChange"                => (string)$user->updated_at,
	        "token"                     => $user->token,
            "currencyType"              => $user->currency_type,
            "currencyCode"              => $currency ? $currency->code : '',
            "currencyCodeAr"            => $currency ? $currency->arabic_code : '',
            "currencySymbol"            => $currency ? $currency->symbol : '',
            "currencySymbolAr"          => $currency ? $currency->arabic_symbol : '',
        ];
    }

    /**
     * @param User $user
     * @return Fractal\Resource\Item
     */
    public function includeProfile(User $user)
	{
		$profile = $user->profile;
		return $this->item($profile, new ProfileTransformer());
	}

    /**
     * @param User $user
     * @return Fractal\Resource\Item|Fractal\Resource\Primitive
     */
    public function includeSocial(User $user)
	{
		$social = $user->social;
		$data = ['data' => $social];
		return $social ? $this->item($social, new SocialTransformer()) : $this->primitive($data);
	}

    /**
     * @param User $user
     * @return Fractal\Resource\Item|Fractal\Resource\Primitive
     */
    public function includeIdCard(User $user)
    {
        $idCard = ID_Card::lastIdCard($user->profile)->first();
        $data = ['data' => $idCard];
        return $idCard ? $this->item($idCard, new IdCardTransformer()) : $this->primitive($data);
    }

    /**
     * @param User $user
     * @return Fractal\Resource\Item|Fractal\Resource\Primitive
     */
    public function includeDriverLicenceCard(User $user)
    {
        $driverLicence = DriverLicence::lastDLCard($user->profile)->first();
        $data = ['data' => $driverLicence];
        return $driverLicence ? $this->item($driverLicence, new DriverLicenceTransformer()) : $this->primitive($data);
    }

    /**
     * @param User $user
     *
     * @return Fractal\Resource\Collection|Fractal\Resource\NullResource
     */
    public function includeFavoriteCar(User $user)
    {
        $favorite = $user->favoriteCar;
        return $this->collection($favorite, new FavoriteCarTransformer());
    }

    /**
     * @param User $user
     * @return Fractal\Resource\Collection|null
     */
    public function includeRecentlyViewedCar(User $user)
    {
        $recentlyCarViewed = $user->recentlyViewedCar;
        return $this->collection($recentlyCarViewed, new RecentlyViewedCarTransformer());
    }
}
