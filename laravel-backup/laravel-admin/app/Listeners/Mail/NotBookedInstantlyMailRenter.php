<?php

namespace App\Listeners\Mail;

use App\Events\Mail\NotBookedInstantlyEvent;
use App\Mail\TripMail\RequestTripRenterMail;
use App\User;
use Mail;

class NotBookedInstantlyMailRenter
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
     * @param  NotBookedInstantlyEvent  $event
     * @return void
     */
    public function handle(NotBookedInstantlyEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
	        Mail::to($renter)->send(new RequestTripRenterMail($event->trip, $renter));
        }
    }
}
