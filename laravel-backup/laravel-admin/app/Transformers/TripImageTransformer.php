<?php

namespace App\Transformers;

use App\TripImages;
use League\Fractal\TransformerAbstract;

/**
 * Class TripImageTransformer
 * @package App\Transformers
 */
class TripImageTransformer extends TransformerAbstract
{

    /**
     * @param TripImages $image
     * @return array
     */
    public function transform(TripImages $image)
    {
        return [
            'imageId' => $image->id,
            'tripid' => $image->trip_id,
            'userId' => $image->user_id,
            'imagePath' => (string)$image->image_path,
            'isBeforeTrip' => (boolean)$image->before_trip,
            'createdAt' => (string)$image->created_at
        ];
    }
}
