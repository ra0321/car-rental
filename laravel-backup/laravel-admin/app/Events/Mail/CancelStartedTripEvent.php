<?php

namespace App\Events\Mail;


/**
 * Class CancelStartedTripEvent
 * @package App\Events\Mail
 */
class CancelStartedTripEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * CancelStartedTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
