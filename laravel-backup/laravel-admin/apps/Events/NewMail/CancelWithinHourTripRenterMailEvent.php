<?php

namespace App\Events\NewMail;


/**
 * Class CancelWithinHourTripRenterMailEvent
 * @package App\Events\NewMail
 */
class CancelWithinHourTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * CancelWithinHourTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
