<?php

namespace App\Listeners\Mail;

use App\Events\Mail\RejectTripModificationEvent;
use App\Mail\TripMail\RejectModificationTripOwnerMail;
use App\User;
use Mail;

class RejectTripModificationOwnerListener
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
     * @param  RejectTripModificationEvent  $event
     * @return void
     */
    public function handle(RejectTripModificationEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new RejectModificationTripOwnerMail($event->trip));
        }
    }
}
