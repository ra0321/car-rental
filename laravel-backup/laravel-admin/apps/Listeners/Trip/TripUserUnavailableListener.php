<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripUserUnavailableEvent;
use App\UserAvailable;
use PDOException;

class TripUserUnavailableListener
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
     * @param  TripUserUnavailableEvent  $event
     * @return void
     */
    public function handle(TripUserUnavailableEvent $event)
    {
        $userAvailable = new UserAvailable();
        $userAvailable['user_id'] = $event->data['user']->id;
        $userAvailable['trip_id'] = $event->data['trip']->id;
        $userAvailable['unavailable_from'] = $event->data['price_from_date'];;
        $userAvailable['unavailable_to'] = $event->data['price_until_date'];
        try{
            $userAvailable->save();
        }catch(PDOException $exception){
            $error_message = $exception->getMessage();
            $error_code = (int)$exception->getCode();
            throw new PDOException($error_message, $error_code);
        }
    }
}
