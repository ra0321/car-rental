<?php

namespace App\Events\Prepare;

/**
 * Class PendingEmailEvent
 * @package App\Events\Prepare
 */
class PendingEmailEvent
{

    /**
     * @var
     */
    public $event_name;
    /**
     * @var
     */
    public $trip_id;
    /**
     * @var
     */
    public $user_id;

    /**
     * PendingEmailEvent constructor.
     * @param $event_name
     * @param $trip_id
     * @param $user_id
     */
    public function __construct($event_name, $trip_id = null, $user_id = null)
    {
        $this->event_name = $event_name;
        $this->trip_id = $trip_id;
        $this->user_id = $user_id;
    }
}
