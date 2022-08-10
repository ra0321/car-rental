<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class RejectModifyTripNotificationEvent
 * @package App\Events\Activity
 */
class RejectModifyTripNotificationEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * RejectModifyTripNotificationEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
