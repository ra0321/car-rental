<?php

namespace App\Events\NewMail;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class TripRejectedOwnerMailEvent
 * @package App\Events\NewMail
 */
class TripRejectedOwnerMailEvent
{
    /**
     * @var
     */
    public $trip;

    /**
     * TripRejectedOwnerMailEvent constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
    }
}
