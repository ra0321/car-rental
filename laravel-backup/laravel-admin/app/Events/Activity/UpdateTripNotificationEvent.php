<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UpdateTripNotificationEvent
 * @package App\Events\Activity
 */
class UpdateTripNotificationEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * UpdateTripNotificationEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
