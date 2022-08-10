<?php

namespace App\Events\Mail;


/**
 * Class FinishTripEvent
 * @package App\Events\Mail
 */
class FinishTripEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * FinishTripEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
