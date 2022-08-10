<?php

namespace App\Listeners\Mail;

use App\Events\Mail\FinishTripEvent;
use App\Mail\TripMail\FinishTripOwnerMail;
use App\User;
use Mail;

class FinishTripMailOwnerListener
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
     * @param  FinishTripEvent  $event
     * @return void
     */
    public function handle(FinishTripEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new FinishTripOwnerMail($event->trip));
        }
    }
}
