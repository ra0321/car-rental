<?php

namespace App\Listeners\Mail;

use App\Events\Mail\CancelStartedTripEvent;
use App\Mail\TripMail\CancelStartedTripRenterMail;
use App\User;
use Mail;

class CancelStartedTripMailRenter
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
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
	        Mail::to($renter)->send(new CancelStartedTripRenterMail($event->trip));
        }
    }
}
