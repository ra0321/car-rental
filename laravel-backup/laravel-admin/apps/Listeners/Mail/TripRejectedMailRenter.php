<?php

namespace App\Listeners\Mail;

use App\Events\Mail\TripRejectedEvent;
use App\Mail\TripMail\RejectTripRenterMail;
use App\User;
use Mail;

class TripRejectedMailRenter
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
     * @param  TripRejectedEvent  $event
     * @return void
     */
    public function handle(TripRejectedEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
	        Mail::to($renter)->send(new RejectTripRenterMail($event->trip));
        }
    }
}
