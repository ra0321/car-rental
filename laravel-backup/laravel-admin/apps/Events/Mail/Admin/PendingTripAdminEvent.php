<?php

namespace App\Events\Mail\Admin;

/**
 * Class PendingTripAdminEvent
 * @package App\Events\Mail\Admin
 */
class PendingTripAdminEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * PendingTripAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
