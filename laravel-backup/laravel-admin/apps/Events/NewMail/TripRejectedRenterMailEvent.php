<?php

namespace App\Events\NewMail;


/**
 * Class TripRejectedRenterMailEvent
 * @package App\Events\NewMail
 */
class TripRejectedRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * TripRejectedRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
