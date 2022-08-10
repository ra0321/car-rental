<?php

namespace App\Events\Mail;


/**
 * Class AcceptTripRequestEvent
 * @package App\Events\Mail
 */
class AcceptTripRequestEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AcceptTripRequestEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
