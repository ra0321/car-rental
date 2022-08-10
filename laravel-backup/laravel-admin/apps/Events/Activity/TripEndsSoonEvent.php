<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripEndsSoonEvent
 * @package App\Events\Activity
 */
class TripEndsSoonEvent
{
    use Dispatchable;

	/**
	 * @var
	 */
	public $trip;

	/**
	 * TripEndsSoonEvent constructor.
	 *
	 * @param $trip
	 */
	public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
