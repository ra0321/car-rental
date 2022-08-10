<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class AutoCancelTripEvent
 * @package App\Events\Activity
 */
class AutoCancelTripEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * AutoCancelTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
