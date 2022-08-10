<?php

namespace App\Transformers;

use App\Chat;
use App\Social;
use League\Fractal\TransformerAbstract;

/**
 * Class ChatTransformer
 * @package App\Transformers
 */
class ChatTransformer extends TransformerAbstract
{

    /**
     * @param Chat $chat
     * @return array
     */
    public function transform(Chat $chat)
    {
        $owner = Social::where('user_id', $chat->owner_id)->first();
        $renter = Social::where('user_id', $chat->renter_id)->first();
        return [
            'chatId' => (int)$chat->id,
            'tripId' => (int)$chat->trip_id,
            'carId' => (int)$chat->car_id,
            'carManufacturer' => (string)$chat->car_manufacturer,
            'carManufacturerArabic' => (string)$chat->car_manufacturer_arabic,
            'carModel' => (string)$chat->car_model,
            'carOriginalImagePath' => (string)$chat->car_original_image_path,
            'carSmallImagePath' => (string)$chat->car_small_image_path,
            'ownerId' => (int)$chat->owner_id,
            'ownerFirstName' => isset($chat->owner_first_name) ? (string)$chat->owner_first_name : null,
            'ownerLastName' => isset($chat->owner_last_name) ? (string)$chat->owner_last_name : null,
            'ownerProfilePhoto' => isset($chat->owner_profile_photo) ? (string)$chat->owner_profile_photo : null,
            'ownerProfilePhotoHeader' => isset($chat->owner_profile_photo_header) ? (string)$chat->owner_profile_photo_header : null,
            'ownerSocialPhoto' => isset($owner) ? $owner->picture_url : null,
            'renterId' => (int)$chat->renter_id,
            'renterFirstName' => isset($chat->renter_first_name) ? (string)$chat->renter_first_name : null,
            'renterLastName' => isset($chat->renter_last_name) ? (string)$chat->renter_last_name : null,
            'renterProfilePhoto' => isset($chat->renter_profile_photo) ? (string)$chat->renter_profile_photo : null,
            'renterProfilePhotoHeader' => isset($chat->renter_profile_photo_header) ? (string)$chat->renter_profile_photo_header : null,
            'renterSocialPhoto' => isset($renter) ? $renter->picture_url : null,
            'lastMessage' => isset($chat->last_message) ? (string)$chat->last_message : null,
            'lastMessageDate' => isset($chat->last_message_date) ? (string)$chat->last_message_date : null,
            'creationDate' => (string)$chat->created_at,
            'unRead' => isset($chat->unRead) ? $chat->unRead : null,
        ];
    }
}
