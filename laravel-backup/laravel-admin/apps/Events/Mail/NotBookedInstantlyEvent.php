<?php

namespace App\Events\Mail;

use App\Trip;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class NotBookedInstantlyEvent
 * @package App\Events\Mail
 */
class NotBookedInstantlyEvent
{
    use Dispatchable;

    /**
     * @var Trip
     */
    public $trip;

    /**
     * NotBookedInstantlyEvent constructor.
     * @param Trip $trip
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }
}
