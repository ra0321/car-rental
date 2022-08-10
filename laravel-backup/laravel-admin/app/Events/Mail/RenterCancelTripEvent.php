<?php

namespace App\Events\Mail;

use App\Trip;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class RenterCancelTripEvent
 * @package App\Events\Mail
 */
class RenterCancelTripEvent
{
    use Dispatchable;

	/**
	 * @var Trip
	 */
	public $trip;

	/**
	 * RenterCancelTripEvent constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }
}
