<?php

namespace App\Events\Trip;

use App\Trip;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripCreateChatEvent
 * @package App\Events\Trip
 */
class TripCreateChatEvent
{
    use Dispatchable;

	/**
	 * @var
	 */
	public $trip;

	/**
	 * TripCreateChatEvent constructor.
	 *
	 * @param $trip
	 */
	public function __construct(Trip &$trip)
    {
        $this->trip = $trip;
    }
}
