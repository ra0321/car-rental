<?php

namespace App\Events\NewMail;


/**
 * Class TripRequestRenterMailEvent
 * @package App\Events\NewMail
 */
class TripRequestRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * TripRequestRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
