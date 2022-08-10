<?php

namespace App\Events\NewMail;


/**
 * Class FinishTripRenterMailEvent
 * @package App\Events\NewMail
 */
class FinishTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * FinishTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
