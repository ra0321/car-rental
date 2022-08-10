<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AutoCancelTripMailEvent;
use App\Mail\TripMail\AutoCancelTripRenterMail;
use App\User;
use Mail;

class AutoCancelTripMailRenter
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
     * @param  AutoCancelTripMailEvent  $event
     * @return void
     */
    public function handle(AutoCancelTripMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
	        Mail::to($renter)->send(new AutoCancelTripRenterMail($event->trip));
        }
    }
}
