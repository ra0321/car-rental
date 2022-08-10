<?php

namespace App\Listeners;

use App\Events\UpdateCar;
use App\User;

class CountListedCars
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
     * @param  UpdateCar  $event
     * @return void
     */
    public function handle(UpdateCar $event)
    {
        $user_id = $event->car->user_id;
        $user = User::findOrFail($user_id);
	    $old = $event->car->getOriginal('car_is_active');
        if($event->car->car_is_active != $old && $event->car->car_is_active == 1){
        	$user['listed'] = $user['listed'] + 1;
        	$user->save();
        }else if($event->car->car_is_active != $old && $event->car->car_is_active == 0){
	        $user['listed'] = $user['listed'] - 1;
	        $user->save();
        }
    }
}
