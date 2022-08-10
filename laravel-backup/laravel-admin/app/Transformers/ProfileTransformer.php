<?php

namespace App\Transformers;

use App\DriverLicence;
use App\ID_Card;
use App\Profile;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class ProfileTransformer
 * @package App\Transformers
 */
class ProfileTransformer extends TransformerAbstract
{
	/**
	 * @param Profile $profile
	 *
	 * @return array
	 */
	public function transform(Profile $profile)
    {
    	$idCard = ID_Card::LastIdCard($profile)->first();
    	$driverLicence = DriverLicence::lastDLCard($profile)->first();
        if(isset($idCard->dob)){
            $age = self::countAge($idCard->dob);
        }

        return [
	        "userId"                    => (int)$profile->user_id,
	        "age"                       => isset($age) ? (int)$age : null,
	        "userWorks"                 => isset($profile->works) ? (string)$profile->works : null,
	        "userAddress"               => isset($profile->address) ? (string)$profile->address : null,
	        "userSchool"                => isset($profile->school) ? (string)$profile->school : null,
	        "userLanguage"              => isset($profile->language) ? (string)$profile->language : null,
	        "aboutMe"                   => isset($profile->about_me) ? (string)$profile->about_me : null,
	        "largeProfilePhotoPath"     => isset($profile->profile_photo) ? (string)$profile->profile_photo : null,
	        "smallProfilePhotoPath"     => isset($profile->profile_photo_header) ? (string)$profile->profile_photo_header : null,
	        "creationDate"              => (string)$profile->created_at,
	        "lastChange"                => (string)$profile->updated_at,
            "hasID"                     => isset($idCard) ? true : false,
            "hasDL"                     => isset($driverLicence) ? true : false,

            "IDNumber"                  => isset($idCard->id_number) ? (string)$idCard->id_number : null,
            "firstNameID"               => isset($idCard->first_name) ? (string)$idCard->first_name : null,
            "lastNameID"                => isset($idCard->last_name) ? (string)$idCard->last_name : null,
            "middleNameID"              => isset($idCard->middle_name) ? (string)$idCard->middle_name : null,
            "dateOfBirth"               => isset($idCard->dob) ? (string)$idCard->dob : '',
            "countryID"                 => isset($idCard->id_country) ? (string)$idCard->id_country : null,
            "stateID"                   => isset($idCard->id_state) ? (string)$idCard->id_state : null,
            "cityID"                    => isset($idCard->id_city) ? (string)$idCard->id_city : null,
            "dateOfIssue"               => isset($idCard->date_of_issue) ? (string)$idCard->date_of_issue : null,
            "expirationDate"            => isset($idCard->expiration_date) ? (string)$idCard->expiration_date : null,
            "issuedBy"                  => isset($idCard->issued_by) ? (string)$idCard->issued_by : null,
            "imageIdPath"               => isset($idCard->image_path) ? (string)$idCard->image_path : null,
            "imageIdPathSmall"          => isset($idCard->image_path_small) ? (string)$idCard->image_path_small : null,

            "driverLicenceNumber"       => isset($driverLicence->dl_number) ? (string)$driverLicence->dl_number : null,
            "driverLicenceExpirationDate" => isset($driverLicence->expiration_date) ? (string)$driverLicence->expiration_date : null,
            "driverLicenceDateOfIssue"    => isset($driverLicence->date_of_issue) ? (string)$driverLicence->date_of_issue : null,
            "driverLicenceImage"        => isset($driverLicence->image_path) ? (string)$driverLicence->image_path : null,
            "driverLicenceImageSmall"   => isset($driverLicence->image_path_small) ? (string)$driverLicence->image_path_small : null,

        ];
    }

	/**
	 * @param $dob
	 *
	 * @return int
	 */
	private static function countAge($dob)
    {
    	$dateOfBirth = Carbon::parse($dob);
	    $age = Carbon::now()->diffInYears($dateOfBirth);
    	return $age;
    }
}
