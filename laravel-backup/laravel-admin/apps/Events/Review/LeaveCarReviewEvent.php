<?php

namespace App\Events\Review;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class LeaveCarReviewEvent
 * @package App\Events\Review
 */
class LeaveCarReviewEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $user;
    /**
     * @var
     */
    public $review;
    /**
     * @var
     */
    public $trip;
    /**
     * @var
     */
    public $reviewMessage;

    /**
     * LeaveCarReviewEvent constructor.
     * @param $user
     * @param $review
     * @param $trip
     * @param $reviewMessage
     */
    public function __construct($user, $review, $trip, $reviewMessage)
    {
        $this->user = $user;
        $this->review = $review;
        $this->trip = $trip;
        $this->reviewMessage = $reviewMessage;
    }
}
