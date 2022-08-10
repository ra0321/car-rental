<?php

namespace App\Listeners\Mail;

use App\Events\Mail\ModifyTripEvent;
use App\Mail\TripMail\ModifyTripOwnerMail;
use App\User;
use Mail;

class ModifyTripMailOwner
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
     * @param  ModifyTripEvent  $event
     * @return void
     */
    public function handle(ModifyTripEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new ModifyTripOwnerMail($event->trip));
        }
    }
}
