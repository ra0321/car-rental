<?php

namespace App\Listeners\Trip;

use App\Chat;
use App\Events\Trip\TripCreateChatEvent;
use PDOException;

class TripCreateChatListeners
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
     * @param  TripCreateChatEvent  $event
     * @return void
     */
    public function handle(TripCreateChatEvent $event)
    {
	    $chat = Chat::where('renter_id', $event->trip->renter_id)
	                ->where('owner_id', $event->trip->owner_id)
	                ->first();
	    if($chat){
		    $event->trip['chat_id'] = $chat['id'];
		    $chat['trip_id'] = $event->trip->id;
		    try{
			    $chat->save();
			    $event->trip->save();
		    }catch(PDOException $exception){
			    $error_message = $exception->getMessage();
			    $error_code = (int)$exception->getCode();
			    throw new PDOException($error_message, $error_code);
		    }
	    }else{
		    $newChat = new Chat();
		    $newChat['trip_id'] = $event->trip->id;
		    $newChat['renter_id'] = $event->trip->renter_id;
		    $newChat['owner_id'] = $event->trip->owner_id;
		    try{
			    $newChat->save();
			    $event->trip['chat_id'] = $newChat['id'];
			    $event->trip->save();
		    }catch(PDOException $exception){
			    $error_message = $exception->getMessage();
			    $error_code = (int)$exception->getCode();
			    throw new PDOException($error_message, $error_code);
		    }

	    }
    }
}
