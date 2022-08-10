<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripFinishedEvent
 * @package App\Events\Activity
 */
class TripFinishedEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * TripFinishedEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
