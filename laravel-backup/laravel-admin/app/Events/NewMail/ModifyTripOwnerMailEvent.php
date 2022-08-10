<?php

namespace App\Events\NewMail;


/**
 * Class ModifyTripOwnerMailEvent
 * @package App\Events\NewMail
 */
class ModifyTripOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * ModifyTripOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
