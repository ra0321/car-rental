<?php

namespace App\Listeners\Activity;

use App\ActivityNotification;
use App\ActivityRequest;
use App\Events\Activity\UpdateTripNotificationEvent;

class UpdateTripNotificationActivity
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
     * @param  UpdateTripNotificationEvent  $event
     * @return void
     */
    public function handle(UpdateTripNotificationEvent $event)
    {
        $tripRequest = new ActivityRequest();
        $tripRequest['owner_id'] = $event->trip['owner_id'];
        $tripRequest['renter_id'] = $event->trip['renter_id'];
        $tripRequest['car_id'] = $event->trip['car_id'];
        $tripRequest['trip_id'] = $event->trip['id'];
        $tripRequest['activity_request_type'] = 20;
        $tripRequest->save();

        $tripNotification = new ActivityNotification();
        $tripNotification['user_id'] = $event->trip['renter_id'];
        $tripNotification['relatedUser_id'] = $event->trip['owner_id'];
        $tripNotification['car_id'] = $event->trip['car_id'];
        $tripNotification['trip_id'] = $event->trip['id'];
        $tripNotification['activity_notification_type'] = 1020;
        $tripNotification->save();
    }
}
