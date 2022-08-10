<?php

namespace App\Events\NewMail;


/**
 * Class OwnerCancelTripRenterMailEvent
 * @package App\Events\NewMail
 */
class OwnerCancelTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * OwnerCancelTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
