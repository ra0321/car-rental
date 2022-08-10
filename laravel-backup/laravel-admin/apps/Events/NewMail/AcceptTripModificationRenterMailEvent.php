<?php

namespace App\Events\NewMail;


/**
 * Class AcceptTripModificationRenterMailEvent
 * @package App\Events\NewMail
 */
class AcceptTripModificationRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AcceptTripModificationRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
