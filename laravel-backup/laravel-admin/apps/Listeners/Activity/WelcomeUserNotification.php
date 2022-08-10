<?php

namespace App\Listeners\Activity;

use App\ActivityNotification;
use App\Events\Activity\WelcomeUserEvent;

/**
 * Class WelcomeUserNotification
 * @package App\Listeners\Activity
 */
class WelcomeUserNotification
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
     * @param  WelcomeUserEvent  $event
     * @return void
     */
    public function handle(WelcomeUserEvent $event)
    {
	    $newCarNotification = new ActivityNotification();
	    $newCarNotification['user_id'] = $event->user['id'];
	    $newCarNotification['activity_notification_type'] = 280;
	    $newCarNotification->save();
    }
}
