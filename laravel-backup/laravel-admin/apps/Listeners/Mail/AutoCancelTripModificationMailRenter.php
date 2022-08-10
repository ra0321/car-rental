<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AutoCancelTripModificationEvent;
use App\Mail\TripMail\AutoCancelModificationRenterMail;
use App\User;
use Mail;

class AutoCancelTripModificationMailRenter
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
     * @param  AutoCancelTripModificationEvent  $event
     * @return void
     */
    public function handle(AutoCancelTripModificationEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true) {
	        Mail::to( $renter )->send( new AutoCancelModificationRenterMail( $event->trip ) );
        }
    }
}
