<?php

namespace App\Events\NewMail;


/**
 * Class RenterCancelTripRenterMailEvent
 * @package App\Events\NewMail
 */
class RenterCancelTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * RenterCancelTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
