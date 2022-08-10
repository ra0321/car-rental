<?php

namespace App\Transformers;

use App\ActivityNotification;
use App\Car;
use App\Social;
use App\SocialConnections;
use App\Trip;
use League\Fractal\TransformerAbstract;

/**
 * Class ActivityNotificationTransformer
 * @package App\Transformers
 */
class ActivityNotificationTransformer extends TransformerAbstract
{
    /**
     * @param ActivityNotification $activityNotification
     * @return array
     */
    public function transform(ActivityNotification $activityNotification)
    {
        $userImages = $this->findProfileImage($activityNotification->user);
        $relatedUserImages = $this->findProfileImage($activityNotification->relatedUser);
        return [
            'activityNotificationId' => (int)$activityNotification->id,
            'activityNotificationType' => (int)$activityNotification->activity_notification_type,
            'activityNotificationStatus' => (boolean)$activityNotification->status,
            'userId' => (int)$activityNotification->user_id,
            'userFirstName' => isset($activityNotification->user->first_name) ? $activityNotification->user->first_name : null,
            'userLastName' => isset($activityNotification->user->last_name) ? $activityNotification->user->last_name : null,
            'userImageLarge' => $userImages['profileImageLarge'],
            'userImageSmall' => $userImages['profileImageSmall'],
            'relatedUserId' => isset($activityNotification->relatedUser->id) ? (int)$activityNotification->relatedUser->id : null,
            'relatedUserFirstName' => isset($activityNotification->relatedUser->first_name) ? $activityNotification->relatedUser->first_name : null,
            'relatedUserLastName' => isset($activityNotification->relatedUser->last_name) ? $activityNotification->relatedUser->last_name : null,
            'relatedUserImageLarge' => $relatedUserImages['profileImageLarge'],
            'relatedUserImageSmall' => $relatedUserImages['profileImageSmall'],
            'carId' => isset($activityNotification->car->id) ? (int)$activityNotification->car->id : null,
            'carManufacturer' => isset($activityNotification->car->car_manufacturer) ? $activityNotification->car->car_manufacturer : null,
            'carManufacturerArabic' => isset($activityNotification->car->car_manufacturer_arabic) ? $activityNotification->car->car_manufacturer_arabic : null,
            'carModel' => isset($activityNotification->car->car_model) ? $activityNotification->car->car_model : null,
            'carModelArabic' => isset($activityNotification->car->car_model) ? $activityNotification->car->car_model : null,
            'productionYear' => isset($activityNotification->car->production_year) ? (int)$activityNotification->car->production_year : null,
            'carImageLarge' => isset($activityNotification->car->carImage[0]->original_image_path) ? $activityNotification->car->carImage[0]->original_image_path : null,
            'carImageSmall' => isset($activityNotification->car->carImage[0]->small_image_path) ? $activityNotification->car->carImage[0]->small_image_path : null,
            'tripId' => isset($activityNotification->trip_id) ? (int)$activityNotification->trip_id : null,
            'ownerId' => isset($trip) ? (int)$trip->owner_id : null,
            'createdAt' => (string)$activityNotification->created_at,
            'updatedAt' => (string)$activityNotification->updated_at,
        ];
    }

    /**
     * @param $user
     * @return array
     */
    private function findProfileImage($user)
    {
        $profileImages = [];
        $userProfileImage = isset($user->profile) ? $user->profile->profile_photo : null;
        $userSocialProfileImage = isset($user->social->picture_url) ? $user->social->picture_url : null;
        switch(true){
            case $userProfileImage:
                $profileImages['profileImageLarge'] = $userProfileImage;
                $profileImages['profileImageSmall'] = $user->profile->profile_photo_header;
                break;
            case $userSocialProfileImage:
                $profileImages['profileImageLarge'] = $userSocialProfileImage;
                $profileImages['profileImageSmall'] = $userSocialProfileImage;
                break;
            default:
                $profileImages['profileImageLarge'] = null;
                $profileImages['profileImageSmall'] = null;
        }
        return $profileImages;
    }
}
