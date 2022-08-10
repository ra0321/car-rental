<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AutoCancelTripModificationEvent;
use App\Mail\TripMail\AutoCancelModificationOwnerMail;
use App\User;
use Mail;

class AutoCancelTripModificationMailOwner
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
     * @param  AutoCancelTripModificationEvent  $event
     * @return void
     */
    public function handle(AutoCancelTripModificationEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new AutoCancelModificationOwnerMail($event->trip));
        }
    }
}
