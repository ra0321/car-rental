<?php

namespace App\Events\NewMail;


/**
 * Class FinishTripOwnerMailEvent
 * @package App\Events\NewMail
 */
class FinishTripOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * FinishTripOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
