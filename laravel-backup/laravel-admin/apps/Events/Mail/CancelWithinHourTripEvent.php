<?php

namespace App\Events\Mail;


/**
 * Class CancelWithinHourTripEvent
 * @package App\Events\Mail
 */
class CancelWithinHourTripEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * CancelWithinHourTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
