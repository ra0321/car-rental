<?php

namespace App\Listeners\Activity;

use App\ActivityNotification;
use App\Car;
use App\Events\Activity\CarStatusesEvent;

class CarStatusesActivity
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
     * @param  CarStatusesEvent  $event
     * @return void
     */
    public function handle(CarStatusesEvent $event)
    {
    	$car = Car::findOrFail($event->carUnlisted->car_id);
        $carStatus = $event->carUnlisted->car_status;
        switch ($carStatus){
            case($carStatus === 'listed'):
                $activity = new ActivityNotification();
                $activity['user_id'] = $event->user->id;
                $activity['car_id'] = $event->carUnlisted->car_id;
                $activity['activity_notification_type'] = 180;
                $car->listedCar($event->user, $car);
                $activity->save();
                break;
            case($carStatus === 'unlisted'):
                $activity = new ActivityNotification();
                $activity['user_id'] = $event->user->id;
                $activity['car_id'] = $event->carUnlisted->car_id;
                $activity['activity_notification_type'] = 190;
                $activity->save();
                break;
            case($carStatus === 'snoozed'):
                $activity = new ActivityNotification();
                $activity['user_id'] = $event->user->id;
                $activity['car_id'] = $event->carUnlisted->car_id;
                $activity['activity_notification_type'] = 200;
                $activity->save();
                break;
            case($carStatus === 'deleted'):
                $activity = new ActivityNotification();
                $activity['user_id'] = $event->user->id;
                $activity['car_id'] = $event->carUnlisted->car_id;
                $activity['activity_notification_type'] = 210;
                $activity->save();
                break;
        }
    }
}
