<?php

namespace App\Events\NewMail;


/**
 * Class CancelStartedTripRenterMailEvent
 * @package App\Events\NewMail
 */
class CancelStartedTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * CancelStartedTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
