<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class OwnerCancelAcceptedTripEvent
 * @package App\Events\Activity
 */
class OwnerCancelAcceptedTripEvent
{
    use Dispatchable;

	/**
	 * @var
	 */
	public $trip;

	/**
	 * OwnerCancelAcceptedTripEvent constructor.
	 *
	 * @param $trip
	 */
	public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
