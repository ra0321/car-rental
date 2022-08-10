<?php

namespace App\Events\NewMail;


class OwnerCancelTripOwnerMailEvent
{
    public $trip;
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
