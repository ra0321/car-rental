<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UpcomingTripEvent
 * @package App\Events\Activity
 */
class UpcomingTripEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * UpcomingTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
