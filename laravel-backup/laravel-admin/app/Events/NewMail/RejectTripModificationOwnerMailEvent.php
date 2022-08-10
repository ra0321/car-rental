<?php

namespace App\Events\NewMail;


/**
 * Class RejectTripModificationOwnerMailEvent
 * @package App\Events\NewMail
 */
class RejectTripModificationOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * RejectTripModificationOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
