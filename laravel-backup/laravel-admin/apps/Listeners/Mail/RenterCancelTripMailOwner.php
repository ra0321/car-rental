<?php

namespace App\Listeners\Mail;

use App\Events\Mail\RenterCancelTripEvent;
use App\Mail\TripMail\RenterCancelTripOwnerMail;
use App\User;
use Mail;

class RenterCancelTripMailOwner
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
     * @param  RenterCancelTripEvent  $event
     * @return void
     */
    public function handle(RenterCancelTripEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new RenterCancelTripOwnerMail($event->trip));
        }
    }
}
