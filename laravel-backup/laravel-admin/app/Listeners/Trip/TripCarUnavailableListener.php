<?php

namespace App\Listeners\Trip;

use App\CarAvailable;
use App\Events\Trip\TripCarUnavailableEvent;
use PDOException;

class TripCarUnavailableListener
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
     * @param  TripCarUnavailableEvent  $event
     * @return void
     */
    public function handle(TripCarUnavailableEvent $event)
    {
	    $carUnavailable = new CarAvailable();
	    $carUnavailable['car_id'] = $event->data['car']->id;
	    $carUnavailable['trip_id'] = $event->data['trip']->id;
	    $carUnavailable['unavailable_from'] = $event->data['trip']->start_date;
	    $carUnavailable['unavailable_to'] = $event->data['trip']->end_date;
	    try{
		    $carUnavailable->save();
	    }catch(PDOException $exception){
		    $error_message = $exception->getMessage();
		    $error_code = (int)$exception->getCode();
		    throw new PDOException($error_message, $error_code);
	    }
    }
}
