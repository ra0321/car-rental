<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AutoCancelTripMailEvent;
use App\Mail\TripMail\AutoCancelTripOwnerMail;
use App\User;
use Mail;

class AutoCancelTripMailOwner
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
     * @param  AutoCancelTripMailEvent  $event
     * @return void
     */
    public function handle(AutoCancelTripMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new AutoCancelTripOwnerMail($event->trip));
        }
    }
}
