<?php

namespace App\Transformers;

use App\Review;
use League\Fractal\TransformerAbstract;

/**
 * Class ReviewTransformer
 * @package App\Transformers
 */
class ReviewTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'reviewMessage'
    ];
    /**
     * @param Review $review
     * @return array
     */
    public function transform(Review $review)
    {
        return [
            'reviewId' => (int)$review->id,
            'tripId' => (int)$review->trip_id,
            'ownerId' => (int)$review->owner_id,
            'renterId' => (int)$review->renter_id
        ];
    }

    /**
     * @param Review $review
     * @return \League\Fractal\Resource\Collection
     */
    public function includeReviewMessage(Review $review)
    {
        $reviewMessage = $review->reviewMessage;
        return $this->collection($reviewMessage, new ReviewMessageTransformer());
    }
}
