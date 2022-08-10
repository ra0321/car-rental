<?php

namespace App\Transformers;

use App\Social;
use League\Fractal\TransformerAbstract;

/**
 * Class SocialTransformer
 * @package App\Transformers
 */
class SocialTransformer extends TransformerAbstract
{

	/**
	 * @param Social $social
	 *
	 * @return array
	 */
	public function transform(Social $social)
    {
        return [
	        'socialId' => (string)$social->social_id,
	        'firstName' => isset($social->first_name) ? (string)$social->first_name : null,
	        'lastName' => isset($social->last_name) ? (string)$social->last_name : null,
	        'email' => isset($social->email) ? (string)$social->email : null,
	        'pictureUrl' => isset($social->picture_url) ? (string)$social->picture_url : null,
	        'friendsCount' => isset($social->friends_count) ? (string)$social->friends_count : null
        ];
    }
}
