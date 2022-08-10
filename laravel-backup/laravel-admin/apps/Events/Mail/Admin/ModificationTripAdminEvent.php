<?php

namespace App\Events\Mail\Admin;

/**
 * Class ModificationTripAdminEvent
 * @package App\Events\Mail\Admin
 */
class ModificationTripAdminEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * ModificationTripAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
