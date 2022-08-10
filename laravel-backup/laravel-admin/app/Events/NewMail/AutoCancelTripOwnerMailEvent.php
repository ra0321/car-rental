<?php

namespace App\Events\NewMail;


/**
 * Class AutoCancelTripOwnerMailEvent
 * @package App\Events\NewMail
 */
class AutoCancelTripOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AutoCancelTripOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
