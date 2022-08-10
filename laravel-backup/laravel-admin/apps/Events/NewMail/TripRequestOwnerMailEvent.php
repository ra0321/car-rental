<?php

namespace App\Events\NewMail;


/**
 * Class TripRequestOwnerMailEvent
 * @package App\Events\NewMail
 */
class TripRequestOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * TripRequestOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
