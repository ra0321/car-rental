<?php

namespace App\Events\NewMail;


/**
 * Class AutoCancelTripModificationOwnerMailEvent
 * @package App\Events\NewMail
 */
class AutoCancelTripModificationOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * AutoCancelTripModificationOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
