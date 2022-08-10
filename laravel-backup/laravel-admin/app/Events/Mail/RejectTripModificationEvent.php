<?php

namespace App\Events\Mail;


/**
 * Class RejectTripModificationEvent
 * @package App\Events\Mail
 */
class RejectTripModificationEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * RejectTripModificationEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
