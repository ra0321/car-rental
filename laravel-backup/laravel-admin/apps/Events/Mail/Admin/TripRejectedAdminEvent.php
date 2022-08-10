<?php

namespace App\Events\Mail\Admin;

/**
 * Class TripRejectedAdminEvent
 * @package App\Events\Mail\Admin
 */
class TripRejectedAdminEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * TripRejectedAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
