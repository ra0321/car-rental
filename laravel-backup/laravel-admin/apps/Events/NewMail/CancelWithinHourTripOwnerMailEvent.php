<?php

namespace App\Events\NewMail;


/**
 * Class CancelWithinHourTripOwnerMailEvent
 * @package App\Events\NewMail
 */
class CancelWithinHourTripOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * CancelWithinHourTripOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
