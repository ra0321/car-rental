<?php

namespace App\Events\Mail;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class AutoCancelTripMailEvent
 * @package App\Events\Mail
 */
class AutoCancelTripMailEvent
{
    use Dispatchable;

	/**
	 * @var
	 */
	public $trip;

	/**
	 * AutoCancelTripMailEvent constructor.
	 *
	 * @param $trip
	 */
	public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
