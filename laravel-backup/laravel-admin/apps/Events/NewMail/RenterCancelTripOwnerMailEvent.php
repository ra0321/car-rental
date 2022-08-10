<?php

namespace App\Events\NewMail;


/**
 * Class RenterCancelTripOwnerMailEvent
 * @package App\Events\NewMail
 */
class RenterCancelTripOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * RenterCancelTripOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
