<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripStartedEvent
 * @package App\Events\Activity
 */
class TripStartedEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * TripStartedEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
