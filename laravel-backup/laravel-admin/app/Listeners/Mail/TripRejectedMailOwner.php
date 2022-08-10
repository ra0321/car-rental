<?php

namespace App\Listeners\Mail;

use App\Events\Mail\TripRejectedEvent;
use App\Mail\TripMail\RejectTripOwnerMail;
use App\User;
use Mail;

class TripRejectedMailOwner
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
     * @param  TripRejectedEvent  $event
     * @return void
     */
    public function handle(TripRejectedEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new RejectTripOwnerMail($event->trip));
        }
    }
}
