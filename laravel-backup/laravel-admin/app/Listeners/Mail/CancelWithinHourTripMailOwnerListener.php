<?php

namespace App\Listeners\Mail;

use App\Events\Mail\CancelWithinHourTripEvent;
use App\Mail\TripMail\CancelWithinHourOwnerMail;
use App\User;
use Mail;

class CancelWithinHourTripMailOwnerListener
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
     * @param  CancelWithinHourTripEvent  $event
     * @return void
     */
    public function handle(CancelWithinHourTripEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new CancelWithinHourOwnerMail($event->trip));
        }
    }
}
