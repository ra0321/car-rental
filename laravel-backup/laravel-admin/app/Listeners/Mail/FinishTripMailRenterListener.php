<?php

namespace App\Listeners\Mail;

use App\Events\Mail\FinishTripEvent;
use App\Mail\TripMail\FinishTripRenterMail;
use App\User;
use Mail;

class FinishTripMailRenterListener
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
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true) {
            Mail::to($renter)->send(new FinishTripRenterMail($event->trip));
        }
    }
}
