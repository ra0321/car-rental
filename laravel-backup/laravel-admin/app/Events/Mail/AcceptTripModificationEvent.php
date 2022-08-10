<?php

namespace App\Events\Mail;


/**
 * Class AcceptTripModificationEvent
 * @package App\Events\Mail
 */
class AcceptTripModificationEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AcceptTripModificationEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
