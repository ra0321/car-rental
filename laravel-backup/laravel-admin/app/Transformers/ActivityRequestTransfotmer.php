<?php

namespace App\Transformers;

use App\ActivityRequest;
use App\Car;
use App\Social;
use App\SocialConnections;
use App\Trip;
use League\Fractal\TransformerAbstract;

/**
 * Class ActivityRequestTransfotmer
 * @package App\Transformers
 */
class ActivityRequestTransfotmer extends TransformerAbstract
{

    /**
     * @param ActivityRequest $activityRequest
     * @return array
     */
    public function transform(ActivityRequest $activityRequest)
    {
    	$trip = Trip::findOrFail($activityRequest->trip_id);
    	if(isset($activityRequest->car_id)){
    		$car = Car::findOrFail($activityRequest->car_id);
	    }
	    $ownerSoc = Social::whereUserId($activityRequest->owner_id)->first();
	    $ownerSocConn = SocialConnections::whereUserId($activityRequest->owner_id)->first();
	    $renterSoc = Social::whereUserId($activityRequest->renter_id)->first();
	    $renterSocConn = SocialConnections::whereUserId($activityRequest->renter_id)->first();

	    switch($activityRequest){
		    case(isset($activityRequest->ownerImageLarge)):
			    $largeProfileImage = $activityRequest->ownerImageLarge;
			    $smallProfileImage = isset($activityRequest->ownerImageLarge) ? $activityRequest->ownerImageLarge : null;
			    break;
		    case(isset($ownerSoc)):
			    $largeProfileImage = $ownerSoc->picture_url;
			    $smallProfileImage = $ownerSoc->picture_url;
			    break;
		    case(isset($ownerSocConn)):
			    $largeProfileImage = $ownerSocConn->picture_url;
			    $smallProfileImage = $ownerSocConn->picture_url;
			    break;
		    default:
			    $largeProfileImage = null;
			    $smallProfileImage = null;
	    }

	    switch($activityRequest){
		    case(isset($activityRequest->renterUserImageLarge)):
			    $renterLargeProfileImage = $activityRequest->renterUserImageLarge;
			    $renterSmallProfileImage = isset($activityRequest->renterUserImageSmall) ? $activityRequest->renterUserImageSmall : null;
			    break;
		    case(isset($renterSoc)):
			    $renterLargeProfileImage = $renterSoc->picture_url;
			    $renterSmallProfileImage = $renterSoc->picture_url;
			    break;
		    case(isset($renterSocConn)):
			    $renterLargeProfileImage = $renterSocConn->picture_url;
			    $renterSmallProfileImage = $renterSocConn->picture_url;
			    break;
		    default:
			    $renterLargeProfileImage = null;
			    $renterSmallProfileImage = null;
	    }

        return [
            'activityNotificationId' => (int)$activityRequest->id,
            'activityRequestType' => (int)$activityRequest->activity_request_type,
            'activityStatus' => (boolean)$activityRequest->status,
            'ownerId' => (int)$activityRequest->owner_id,
            'ownerFirstName' => isset($activityRequest->ownerFirstName) ? $activityRequest->ownerFirstName : null,
            'ownerLastName' => isset($activityRequest->ownerLastName) ? $activityRequest->ownerLastName : null,
            'ownerImageLarge' => $largeProfileImage,
            'ownerImageSmall' => $smallProfileImage,
            'renterId' => (int)$activityRequest->renter_id,
            'renterUserFirstName' => isset($activityRequest->renterUserFirstName) ? $activityRequest->renterUserFirstName : null,
            'renterUserLastName' => isset($activityRequest->renterUserLastName) ? $activityRequest->renterUserLastName : null,
            'renterUserImageLarge' => $renterLargeProfileImage,
            'renterUserImageSmall' => $renterSmallProfileImage,
            'carId' => (int)$activityRequest->car_id,
            'carManufacturer' => isset($activityRequest->carManufacturer) ? $activityRequest->carManufacturer : null,
            'carManufacturerArabic' => isset($activityRequest->carManufacturerArabic) ? $activityRequest->carManufacturerArabic : null,
            'carModel' => isset($activityRequest->carModel) ? $activityRequest->carModel : null,
            'carModelArabic' => isset($activityRequest->carModelArabic) ? $activityRequest->carModelArabic : null,
            'productionYear' => isset($car) ? (int)$car->production_year : null,
            'carImageLarge' => isset($activityRequest->carImageLarge) ? $activityRequest->carImageLarge : null,
            'carImageSmall' => isset($activityRequest->carImageSmall) ? $activityRequest->carImageSmall : null,
	        'startTrip' => (string)$trip->start_date,
	        'endTrip' => (string)$trip->end_date,
            'tripId' => (int)$activityRequest->trip_id,
            'createdAt' => (string)$activityRequest->created_at,
            'updatedAt' => (string)$activityRequest->updated_at,
        ];
    }
}
