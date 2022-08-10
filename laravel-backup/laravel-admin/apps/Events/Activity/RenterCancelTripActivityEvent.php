<?php

namespace App\Events\Activity;

use App\Trip;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class RenterCancelTripActivityEvent
 * @package App\Events\Activity
 */
class RenterCancelTripActivityEvent
{
    use Dispatchable;

	/**
	 * @var Trip
	 */
	public $trip;


	/**
	 * RenterCancelTripActivityEvent constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
	{
		$this->trip = $trip;
	}
}
