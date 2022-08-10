<?php

namespace App\Transformers;

use App\ReviewMessage;
use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class ReviewMessageTransformer
 * @package App\Transformers
 */
class ReviewMessageTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'user'
    ];

    /**
     * @param ReviewMessage $reviewMessage
     * @return array
     */
    public function transform(ReviewMessage $reviewMessage)
    {
        $user = User::findOrFail($reviewMessage->user_id);
        $user_profile = User::findOrFail($reviewMessage->user_id)->profile;
        $user_social = User::findOrFail($reviewMessage->user_id)->social;
        return [
            'reviewId' => (int)$reviewMessage->review_id,
            'userId' => (int)$reviewMessage->user_id,
            'reviewMessage' => (string)$reviewMessage->review_message,
            'ratingStars' => (string)$reviewMessage->stars,
            'dateOfReview' => (string)$reviewMessage->created_at,
            'userFirstName' => (string)$user->first_name,
            'userLastName' => (string)$user->last_name,
            'userProfilePhoto' => (string)$user_profile->profile_photo,
            'userProfilePhotoHeader' => (string)$user_profile->profile_photo_header,
            'socialProfilePhoto' => isset($user_social) ? $user_social->picture_url : null,
        ];
    }

    /**
     * @param ReviewMessage $reviewMessage
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(ReviewMessage $reviewMessage)
    {
        $user = $reviewMessage->user;
        return $this->item($user, new UserTransformer());
    }
}
