<?php

namespace App\Events\Activity;


use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class AcceptModifyTripNotificationEvent
 * @package App\Events\Activity
 */
class AcceptModifyTripNotificationEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * AcceptModifyTripNotificationEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
