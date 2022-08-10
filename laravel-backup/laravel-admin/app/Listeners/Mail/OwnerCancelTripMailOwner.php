<?php

namespace App\Listeners\Mail;

use App\Events\Mail\OwnerCancelTripEvent;
use App\Mail\TripMail\OwnerCancelTripOwnerMail;
use App\User;
use Mail;

class OwnerCancelTripMailOwner
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
     * @param  OwnerCancelTripEvent  $event
     * @return void
     */
    public function handle(OwnerCancelTripEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new OwnerCancelTripOwnerMail($event->trip));
        }
    }
}
