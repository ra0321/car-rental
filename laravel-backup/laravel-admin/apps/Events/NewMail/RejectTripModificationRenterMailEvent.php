<?php

namespace App\Events\NewMail;


/**
 * Class RejectTripModificationRenterMailEvent
 * @package App\Events\NewMail
 */
class RejectTripModificationRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * RejectTripModificationRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
