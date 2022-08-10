<?php

namespace App\Events\Mail;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class AutoCancelTripModificationEvent
 * @package App\Events\Mail
 */
class AutoCancelTripModificationEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * AutoCancelTripModificationEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
