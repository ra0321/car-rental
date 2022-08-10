<?php

namespace App\Listeners\Mail;

use App\Events\Activity\TripEndsSoonEvent;
use App\User;
use Mail;

class TripEndsSoonMailOwner
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
     * @param  TripEndsSoonEvent  $event
     * @return void
     */
    public function handle(TripEndsSoonEvent $event)
    {
	    $owner = User::findOrFail($event->trip->owner_id);
	    if($owner->email_promotions == true){
		    Mail::to($owner)->send(new \App\Mail\TripMail\TripEndsSoonMailOwner($event->trip));
	    }
    }
}
