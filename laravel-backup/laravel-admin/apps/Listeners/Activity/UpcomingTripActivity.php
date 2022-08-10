<?php

namespace App\Listeners\Activity;

use App\ActivityNotification;
use App\Events\Activity\UpcomingTripEvent;

class UpcomingTripActivity
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
     * @param  UpcomingTripEvent  $event
     * @return void
     */
    public function handle(UpcomingTripEvent $event)
    {
        $tripNotificationOwner = new ActivityNotification();
        $tripNotificationOwner['user_id'] = $event->trip['owner_id'];
        $tripNotificationOwner['relatedUser_id'] = $event->trip['renter_id'];
        $tripNotificationOwner['car_id'] = $event->trip['car_id'];
        $tripNotificationOwner['trip_id'] = $event->trip['id'];
        $tripNotificationOwner['activity_notification_type'] = 160;
        $tripNotificationOwner->save();

        $tripNotificationRenter = new ActivityNotification();
        $tripNotificationRenter['user_id'] = $event->trip['renter_id'];
        $tripNotificationRenter['relatedUser_id'] = $event->trip['owner_id'];
        $tripNotificationRenter['car_id'] = $event->trip['car_id'];
        $tripNotificationRenter['trip_id'] = $event->trip['id'];
        $tripNotificationRenter['activity_notification_type'] = 1160;
        $tripNotificationRenter->save();
    }
}
