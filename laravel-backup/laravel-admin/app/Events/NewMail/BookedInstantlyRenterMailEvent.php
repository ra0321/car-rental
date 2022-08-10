<?php

namespace App\Events\NewMail;


class BookedInstantlyRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * BookedInstantlyOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
