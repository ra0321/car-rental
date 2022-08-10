<?php

namespace App\Events\NewMail;


/**
 * Class AutoCancelTripRenterMailEvent
 * @package App\Events\NewMail
 */
class AutoCancelTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AutoCancelTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
