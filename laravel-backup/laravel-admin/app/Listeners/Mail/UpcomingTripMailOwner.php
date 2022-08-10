<?php

namespace App\Listeners\Mail;

use App\Events\Activity\UpcomingTripEvent;
use App\Mail\TripMail\UpcomingTripOwnerMail;
use App\User;
use Mail;

class UpcomingTripMailOwner
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
     * @param  UpcomingTripEvent  $event
     * @return void
     */
    public function handle(UpcomingTripEvent $event)
    {
	    $owner = User::findOrFail($event->trip->owner_id);
	    if($owner->email_promotions == true){
		    Mail::to($owner)->send(new UpcomingTripOwnerMail($event->trip));
	    }
    }
}
