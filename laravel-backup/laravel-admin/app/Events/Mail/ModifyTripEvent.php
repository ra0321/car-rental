<?php

namespace App\Events\Mail;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class ModifyTripEvent
 * @package App\Events\Mail
 */
class ModifyTripEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $trip;

    /**
     * ModifyTripEvent constructor.
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
