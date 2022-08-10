<?php

namespace App\Events\NewMail;


/**
 * Class CancelStartedTripOwnerMailEvent
 * @package App\Events\NewMail
 */
class CancelStartedTripOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * CancelStartedTripOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
