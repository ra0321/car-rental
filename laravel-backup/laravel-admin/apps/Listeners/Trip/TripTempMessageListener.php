<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripTempMessageEvent;
use App\TempMessage;
use App\UserAvailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDOException;

class TripTempMessageListener
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
     * @param  TripTempMessageEvent  $event
     * @return void
     */
    public function handle(TripTempMessageEvent $event)
    {
        $temp_message = new TempMessage();
        $temp_message['trip_id'] = $event->data['trip']->id;
        $temp_message['user_id'] = $event->data['user']->id;
        $temp_message['message'] = $event->data['message'];
        try{
            $temp_message->save();
        }catch(PDOException $exception){
            $error_message = $exception->getMessage();
            $error_code = (int)$exception->getCode();
            throw new PDOException($error_message, $error_code);
        }
    }
}
