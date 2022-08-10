<?php

namespace App\Events\Mail\Admin;


/**
 * Class RenterCancelTripAdminEvent
 * @package App\Events\Mail\Admin
 */
class RenterCancelTripAdminEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * RenterCancelTripAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
