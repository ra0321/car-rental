<?php

namespace App\Listeners\Activity;

use App\ActivityNotification;
use App\Events\Activity\RejectedTripEvent;

class RejectedTripActivity
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
     * @param  RejectedTripEvent  $event
     * @return void
     */
    public function handle(RejectedTripEvent $event)
    {
        $tripNotificationOwner = new ActivityNotification();
        $tripNotificationOwner['user_id'] = $event->trip['owner_id'];
        $tripNotificationOwner['relatedUser_id'] = $event->trip['renter_id'];
        $tripNotificationOwner['car_id'] = $event->trip['car_id'];
        $tripNotificationOwner['trip_id'] = $event->trip['id'];
        //$tripNotificationOwner['activity_notification_type'] = $event->trip['owner_confirm_trip'] === 'canceled' ? 140 : 150;
        $tripNotificationOwner['activity_notification_type'] = 140;
        $tripNotificationOwner->save();

        $tripNotificationRenter = new ActivityNotification();
        $tripNotificationRenter['user_id'] = $event->trip['renter_id'];
        $tripNotificationRenter['relatedUser_id'] = $event->trip['owner_id'];
        $tripNotificationRenter['car_id'] = $event->trip['car_id'];
        $tripNotificationRenter['trip_id'] = $event->trip['id'];
        //$tripNotificationRenter['activity_notification_type'] = $event->trip['owner_confirm_trip'] === 'canceled' ? 1140 : 1150;
        $tripNotificationRenter['activity_notification_type'] = 1140;
        $tripNotificationRenter->save();
    }
}
