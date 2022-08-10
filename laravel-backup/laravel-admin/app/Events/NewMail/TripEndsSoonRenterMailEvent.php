<?php

namespace App\Events\NewMail;


/**
 * Class TripEndsSoonRenterMailEvent
 * @package App\Events\NewMail
 */
class TripEndsSoonRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * TripEndsSoonRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
