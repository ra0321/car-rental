<?php

namespace App\Listeners\Activity;

use App\ActivityNotification;
use App\Events\Activity\OwnerCancelAcceptedTripEvent;

class OwnerCancelAcceptedActivity
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
     * @param  OwnerCancelAcceptedTripEvent  $event
     * @return void
     */
    public function handle(OwnerCancelAcceptedTripEvent $event)
    {
	    $tripNotificationOwner = new ActivityNotification();
	    $tripNotificationOwner['user_id'] = $event->trip['owner_id'];
	    $tripNotificationOwner['relatedUser_id'] = $event->trip['renter_id'];
	    $tripNotificationOwner['car_id'] = $event->trip['car_id'];
	    $tripNotificationOwner['trip_id'] = $event->trip['id'];
	    $tripNotificationOwner['activity_notification_type'] = 340;
	    $tripNotificationOwner->save();

	    $tripNotificationRenter = new ActivityNotification();
	    $tripNotificationRenter['user_id'] = $event->trip['renter_id'];
	    $tripNotificationRenter['relatedUser_id'] = $event->trip['owner_id'];
	    $tripNotificationRenter['car_id'] = $event->trip['car_id'];
	    $tripNotificationRenter['trip_id'] = $event->trip['id'];
	    $tripNotificationRenter['activity_notification_type'] = 1340;
	    $tripNotificationRenter->save();
    }
}
