<?php

namespace App\Listeners\Mail;

use App\Events\Mail\OwnerCancelTripEvent;
use App\Mail\TripMail\OwnerCancelTripRenterMail;
use App\User;
use Mail;

class OwnerCancelTripMailRenter
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
     * @param  OwnerCancelTripEvent  $event
     * @return void
     */
    public function handle(OwnerCancelTripEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true) {
	        Mail::to( $renter )->send( new OwnerCancelTripRenterMail( $event->trip ) );
        }
    }
}
