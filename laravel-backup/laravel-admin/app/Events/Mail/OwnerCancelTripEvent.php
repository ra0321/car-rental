<?php

namespace App\Events\Mail;

use App\Trip;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class OwnerCancelTripEvent
 * @package App\Events\Mail
 */
class OwnerCancelTripEvent
{
    use Dispatchable;

    /**
     * @var Trip
     */
    public $trip;

    /**
     * OwnerCancelTripEvent constructor.
     * @param Trip $trip
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }
}
