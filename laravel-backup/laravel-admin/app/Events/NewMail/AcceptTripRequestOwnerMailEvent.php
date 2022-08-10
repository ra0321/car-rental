<?php

namespace App\Events\NewMail;


/**
 * Class AcceptTripRequestOwnerMailEvent
 * @package App\Events\NewMail
 */
class AcceptTripRequestOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AcceptTripRequestOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
