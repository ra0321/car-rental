<?php

namespace App\Events\Mail\Admin;

/**
 * Class BookedInstantlyAdminEvent
 * @package App\Events\Mail\Admin
 */
class BookedInstantlyAdminEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * BookedInstantlyAdminEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
