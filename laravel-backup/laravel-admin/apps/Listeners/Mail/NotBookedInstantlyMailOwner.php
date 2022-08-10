<?php

namespace App\Listeners\Mail;

use App\Events\Mail\NotBookedInstantlyEvent;
use App\Mail\TripMail\RequestTripOwnerMail;
use App\User;
use Mail;

class NotBookedInstantlyMailOwner
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
     * @param  NotBookedInstantlyEvent  $event
     * @return void
     */
    public function handle(NotBookedInstantlyEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new RequestTripOwnerMail($event->trip));
        }
    }
}
