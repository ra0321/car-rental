<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AcceptTripRequestEvent;
use App\Mail\TripMail\AcceptTripOwnerMail;
use App\User;
use Mail;

class AcceptTripRequestMailOwnerListener
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
     * @param  AcceptTripRequestEvent  $event
     * @return void
     */
    public function handle(AcceptTripRequestEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new AcceptTripOwnerMail($event->trip));
        }
    }
}
