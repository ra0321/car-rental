<?php

namespace App\Events\Review;

use App\User;
use App\Review;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class LeaveReviewEvent
 * @package App\Events\Review
 */
class LeaveReviewEvent 
{
    use Dispatchable;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Review
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
     * LeaveReviewEvent constructor.
     * @param User $user
     * @param Review $review
     */
    public function __construct(User $user, Review $review, $trip, $reviewMessage)
    {
        $this->user = $user;
        $this->review = $review;
        $this->trip = $trip;
        $this->reviewMessage = $reviewMessage;
    }
}
