<?php

namespace App\Traits;

use App\Car;
use App\CarImage;
use App\User;

/**
 * Trait ActivityNotificationTrait
 * @package App\Traits
 */
trait ActivityNotificationTrait
{
    /**
     * @param $activities
     * @return \Illuminate\Support\Collection
     */
    public function activityNotificationResponse($activities)
    {
        foreach ($activities as $activity){
            if(isset($activity->user_id)){
                $user = User::with('profile')->findOrFail($activity->user_id);
                $activity['userFirstName'] = $user->first_name;
                $activity['userLastName'] = $user->last_name;
                $activity['userImageLarge'] = $user->profile->profile_photo;
                $activity['userImageSmall'] = $user->profile->profile_photo_header;
            }
            if(isset($activity->relatedUser_id)){
                $related_user = User::with('profile')->findOrFail($activity->relatedUser_id);
                $activity['relatedUserFirstName'] = $related_user->first_name;
                $activity['relatedUserLastName'] = $related_user->last_name;
                $activity['relatedUserImageLarge'] = $related_user->profile->profile_photo;
                $activity['relatedUserImageSmall'] = $related_user->profile->profile_photo_header;
            }
            if(isset($activity->car_id)){
                //$car = Car::findOrFail($activity->car_id);
                $car = Car::find($activity->car_id);
                $carImage = CarImage::whereCarId($activity->car_id)->first();
                $activity['carManufacturer'] = $car->car_manufacturer;
                $activity['carManufacturerArabic'] = $car->car_manufacturer_arabic;
                $activity['carModel'] = $car->car_model;
                $activity['carModelArabic'] = $car->car_model_arabic;
                $activity['carImageLarge'] = $carImage->original_image_path;
                $activity['carImageSmall'] = $carImage->small_image_path;
            }
        }
        $collections = collect($activities);
        return $collections;
    }

    public function activityRequestResponse($activities)
    {
        foreach ($activities as $activity){
            if(isset($activity->owner_id)){
                $owner = User::with('profile')->findOrFail($activity->owner_id);
                $activity['ownerFirstName'] = $owner->first_name;
                $activity['ownerLastName'] = $owner->last_name;
                $activity['ownerImageLarge'] = $owner->profile->profile_photo;
                $activity['ownerImageSmall'] = $owner->profile->profile_photo_header;
            }
            if(isset($activity->renter_id)){
                $renter = User::with('profile')->findOrFail($activity->renter_id);
                $activity['renterUserFirstName'] = $renter->first_name;
                $activity['renterUserLastName'] = $renter->last_name;
                $activity['renterUserImageLarge'] = $renter->profile->profile_photo;
                $activity['renterUserImageSmall'] = $renter->profile->profile_photo_header;
            }
            if(isset($activity->car_id)){
                $car = Car::findOrFail($activity->car_id);
                $carImage = CarImage::whereCarId($activity->car_id)->first();
                $activity['carManufacturer'] = $car->car_manufacturer;
                $activity['carManufacturerArabic'] = $car->car_manufacturer_arabic;
                $activity['carModel'] = $car->car_model;
                $activity['carModelArabic'] = $car->car_model_arabic;
                $activity['carImageLarge'] = $carImage->original_image_path;
                $activity['carImageSmall'] = $carImage->small_image_path;
            }
        }
        $collections = collect($activities);
        return $collections;
    }
}