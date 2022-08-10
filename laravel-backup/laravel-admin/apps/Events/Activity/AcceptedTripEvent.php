<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class AcceptedTripEvent
 * @package App\Events\Activity
 */
class AcceptedTripEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * AcceptedTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
