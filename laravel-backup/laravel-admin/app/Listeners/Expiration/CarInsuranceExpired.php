<?php

namespace App\Listeners\Expiration;

use App\ActivityNotification;
use App\Events\Expiration\CarInsuranceExpiredEvent;

class CarInsuranceExpired
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
     * @param  CarInsuranceExpiredEvent  $event
     * @return void
     */
    public function handle(CarInsuranceExpiredEvent $event)
    {
	    $newCarNotification = new ActivityNotification();
	    $newCarNotification['user_id'] = $event->car->user_id;
	    $newCarNotification['car_id'] = $event->car->id;
	    $newCarNotification['activity_notification_type'] = 290;
	    $newCarNotification->save();
    }
}
