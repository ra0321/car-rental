<?php

namespace App\Events\NewMail;


/**
 * Class AutoCancelTripModificationRenterMailEvent
 * @package App\Events\NewMail
 */
class AutoCancelTripModificationRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AutoCancelTripModificationRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
