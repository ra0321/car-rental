<?php

namespace App\Listeners\Expiration;

use App\ActivityNotification;
use App\Events\Expiration\LicencePlateExpiredEvent;

class LicencePlateExpired
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
     * @param  LicencePlateExpiredEvent  $event
     * @return void
     */
    public function handle(LicencePlateExpiredEvent $event)
    {
	    $newCarNotification = new ActivityNotification();
	    $newCarNotification['user_id'] = $event->car->user_id;
	    $newCarNotification['car_id'] = $event->car->id;
	    $newCarNotification['activity_notification_type'] = 300;
	    $newCarNotification->save();
    }
}
