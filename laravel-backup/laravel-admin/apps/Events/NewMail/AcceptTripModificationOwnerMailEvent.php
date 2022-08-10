<?php

namespace App\Events\NewMail;


/**
 * Class AcceptTripModificationOwnerMailEvent
 * @package App\Events\NewMail
 */
class AcceptTripModificationOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AcceptTripModificationOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
