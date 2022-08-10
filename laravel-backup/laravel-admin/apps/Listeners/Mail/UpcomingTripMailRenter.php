<?php

namespace App\Listeners\Mail;

use App\Events\Activity\UpcomingTripEvent;
use App\Mail\TripMail\UpcomingTripRenterMail;
use App\User;
use Mail;

class UpcomingTripMailRenter
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
	    $renter = User::findOrFail($event->trip->renter_id);
	    if($renter->email_promotions == true){
		    Mail::to($renter)->send(new UpcomingTripRenterMail($event->trip));
	    }
    }
}
