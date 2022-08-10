<?php

namespace App\Listeners\Trip;

use App\Chat;
use App\ChatMessage;
use App\Events\Trip\CreateTripEvent;

class SendMessageEvent
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
     * @param  CreateTripEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $existingChat = Chat::where('renter_id', $event->trip->renter_id)->where('owner_id', $event->trip->owner_id)->get();
        if($existingChat->all()){
            $chatMessage = new ChatMessage();
            $chatMessage['chat_id'] = $existingChat[0]->id;
            $chatMessage['user_id'] = $event->trip->renter_id;
            $chatMessage['message'] = $event->message['message'];
            $chatMessage->save();
        }else{
            $chat = new Chat();
            $chat['trip_id'] = $event->trip->id;
            $chat['renter_id'] = $event->trip->renter_id;
            $chat['owner_id'] = $event->trip->owner_id;
            $chat->save();

            $chatMessage = new ChatMessage();
            $chatMessage['chat_id'] = $chat->id;
            $chatMessage['user_id'] = $event->trip->renter_id;
            $chatMessage['message'] = $event->message['message'];
            $chatMessage->save();
        }
    }
}
