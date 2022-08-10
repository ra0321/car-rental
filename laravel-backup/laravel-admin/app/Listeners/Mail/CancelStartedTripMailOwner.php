<?php

namespace App\Listeners\Mail;

use App\Events\Mail\CancelStartedTripEvent;
use App\Mail\TripMail\CancelStartedTripOwnerMail;
use App\User;
use Mail;

class CancelStartedTripMailOwner
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
     * @param  CancelStartedTripEvent  $event
     * @return void
     */
    public function handle(CancelStartedTripEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new CancelStartedTripOwnerMail($event->trip));
        }
    }
}
