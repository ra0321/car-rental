<?php

namespace App\Events\NewMail;


/**
 * Class ModifyTripRenterMailEvent
 * @package App\Events\NewMail
 */
class ModifyTripRenterMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * ModifyTripRenterMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
