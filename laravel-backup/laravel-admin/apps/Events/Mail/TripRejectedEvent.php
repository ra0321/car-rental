<?php

namespace App\Events\Mail;

use App\Trip;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripRejectedEvent
 * @package App\Events\Mail
 */
class TripRejectedEvent
{
    use Dispatchable;

    /**
     * @var Trip
     */
    public $trip;

    /**
     * TripRejectedEvent constructor.
     * @param Trip $trip
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }
}
