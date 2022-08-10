<?php

namespace App\Events\NewMail;


/**
 * Class UpcomingTripRenterMailEvent
 * @package App\Events\NewMail
 */
class UpcomingTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * UpcomingTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
