<?php

namespace App\Events\Mail\AntiFraud;

class AdminAntiFraudTripEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * BookedInstantlyAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
