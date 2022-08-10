<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripSendMessageEvent
 * @package App\Events\Trip
 */
class TripSendMessageEvent 
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip, $message;

	/**
	 * TripSendMessageEvent constructor.
	 *
	 * @param $trip
	 * @param $message
	 */
	public function __construct($trip, $message)
    {
        $this->trip = $trip;
        $this->message = $message;
    }
}
