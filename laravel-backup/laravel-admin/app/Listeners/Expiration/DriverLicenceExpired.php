<?php

namespace App\Listeners\Expiration;

use App\ActivityNotification;
use App\Events\Expiration\DriverLicenceExpiredEvent;

class DriverLicenceExpired
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
     * @param  DriverLicenceExpiredEvent  $event
     * @return void
     */
    public function handle(DriverLicenceExpiredEvent $event)
    {
	    $newCarNotification = new ActivityNotification();
	    $newCarNotification['user_id'] = $event->user->id;
	    $newCarNotification['activity_notification_type'] = 310;
	    $newCarNotification->save();
    }
}
