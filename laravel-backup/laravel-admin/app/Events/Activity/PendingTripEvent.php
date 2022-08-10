<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class PendingTripEvent
 * @package App\Events\Activity
 */
class PendingTripEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * PendingTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
