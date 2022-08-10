<?php

namespace App\Listeners\Mail;

use App\Events\Activity\TripEndsSoonEvent;
use App\User;
use Mail;

class TripEndsSoonMailRenter
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
	    $renter = User::findOrFail($event->trip->renter_id);
	    if($renter->email_promotions == true){
		    Mail::to($renter)->send(new \App\Mail\TripMail\TripEndsSoonMailRenter($event->trip));
	    }
    }
}
