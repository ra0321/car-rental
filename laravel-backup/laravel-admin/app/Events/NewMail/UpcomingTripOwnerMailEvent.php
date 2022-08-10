<?php

namespace App\Events\NewMail;


/**
 * Class UpcomingTripOwnerMailEvent
 * @package App\Events\NewMail
 */
class UpcomingTripOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * UpcomingTripOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
