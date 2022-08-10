<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class RejectedTripEvent
 * @package App\Events\Activity
 */
class RejectedTripEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * RejectedTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
