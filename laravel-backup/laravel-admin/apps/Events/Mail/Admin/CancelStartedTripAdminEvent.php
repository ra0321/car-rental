<?php

namespace App\Events\Mail\Admin;

/**
 * Class CancelStartedTripAdminEvent
 * @package App\Events\Mail\Admin
 */
class CancelStartedTripAdminEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * CancelStartedTripAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
