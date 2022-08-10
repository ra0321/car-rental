<?php

namespace App\Transformers;

use App\ChatMessage;
use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class ChatMessageTransformer
 * @package App\Transformers
 */
class ChatMessageTransformer extends TransformerAbstract
{

    /**
     * @param ChatMessage $chatMessage
     * @return array
     */
    public function transform(ChatMessage $chatMessage)
    {
        $user = User::findOrFail($chatMessage->user_id);
        $user_profile = User::findOrFail($chatMessage->user_id)->profile;
        $user_social = User::findOrFail($chatMessage->user_id)->social;
        return [
            'chatId' => (int)$chatMessage->chat_id,
            'messageId' => (int)$chatMessage->id,
            'userId' => (int)$chatMessage->user_id,
            'userFirstName' => (string)$user->first_name,
            'userLastName' => (string)$user->last_name,
            'userProfilePhoto' => (string)$user_profile->profile_photo,
            'userProfilePhotoHeader' => (string)$user_profile->profile_photo_header,
            'socialProfilePhoto' => isset($user_social) ? $user_social->picture_url : null,
            'message' => (string)$chatMessage->message,
            'image' => isset($chatMessage->image_path) ? (string)$chatMessage->image_path : null,
            'messageStatus' => (boolean)$chatMessage->status,
            'messageCreated' => (string)$chatMessage->created_at,
            'messageUpdated' => (string)$chatMessage->updated_at,
        ];
    }
}
