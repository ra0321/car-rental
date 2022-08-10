<?php

namespace App\Listeners\Activity;

use App\ActivityNotification;
use App\Events\Activity\CarCreatedEvent;

class CarCreatedActivity
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
     * @param  CarCreatedEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $newCarNotification = new ActivityNotification();
        $newCarNotification['user_id'] = $event->car['user_id'];
        $newCarNotification['car_id'] = $event->car['id'];
        $newCarNotification['activity_notification_type'] = 170;
        $newCarNotification->save();
    }
}
