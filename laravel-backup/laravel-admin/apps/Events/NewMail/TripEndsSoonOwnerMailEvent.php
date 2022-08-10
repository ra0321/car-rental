<?php

namespace App\Events\NewMail;


/**
 * Class TripEndsSoonOwnerMailEvent
 * @package App\Events\NewMail
 */
class TripEndsSoonOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * TripEndsSoonOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
