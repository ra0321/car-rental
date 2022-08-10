<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class AutoCancelModificationTripEvent
 * @package App\Events\Activity
 */
class AutoCancelModificationTripEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * AutoCancelModificationTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
