<?php

namespace App\Events\NewMail;


/**
 * Class BookedInstantlyOwnerMailEvent
 * @package App\Events\NewMail
 */
class BookedInstantlyOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * BookedInstantlyOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
