<?php

namespace App\Events\Mail\Admin;

/**
 * Class OwnerCancelTripAdminEvent
 * @package App\Events\Mail\Admin
 */
class OwnerCancelTripAdminEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * OwnerCancelTripAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
