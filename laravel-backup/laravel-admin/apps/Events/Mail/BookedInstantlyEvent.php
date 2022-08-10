<?php

namespace App\Events\Mail;

use App\Trip;

/**
 * Class BookedInstantlyEvent
 * @package App\Events\Mail
 */
class BookedInstantlyEvent
{
    /**
     * @var Trip
     */
    public $trip;
    /**
     * BookedInstantlyEvent constructor.
     *
     * @param Trip $trip
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }
}