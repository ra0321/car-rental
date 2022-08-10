<?php

namespace App\Listeners\Mail;

use App\Events\Mail\RenterCancelTripEvent;
use App\Mail\TripMail\RenterCancelTripRenterMail;
use App\User;
use Mail;

class RenterCancelTripMailRenter
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
     * @param  RenterCancelTripEvent  $event
     * @return void
     */
    public function handle(RenterCancelTripEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
	        Mail::to($renter)->send(new RenterCancelTripRenterMail($event->trip));
        }
    }
}
