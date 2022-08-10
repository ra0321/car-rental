<?php

namespace App\Events\NewMail;


/**
 * Class AcceptTripRequestRenterEmailEvent
 * @package App\Events\NewMail
 */
class AcceptTripRequestRenterEmailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AcceptTripRequestRenterEmailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
