<?php

namespace App\Listeners\Expiration;

use App\ActivityNotification;
use App\Events\Expiration\IdCardExpiredEvent;

class IdCardExpired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IdCardExpiredEvent  $event
     * @return void
     */
    public function handle(IdCardExpiredEvent $event)
    {
	    $newCarNotification = new ActivityNotification();
	    $newCarNotification['user_id'] = $event->user->id;
	    $newCarNotification['activity_notification_type'] = 320;
	    $newCarNotification->save();
    }
}
