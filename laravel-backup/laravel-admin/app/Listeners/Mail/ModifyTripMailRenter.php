<?php

namespace App\Listeners\Mail;

use App\Events\Mail\ModifyTripEvent;
use App\Mail\TripMail\ModifyTripRenterMail;
use App\User;
use Mail;

class ModifyTripMailRenter
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
     * @param  ModifyTripEvent  $event
     * @return void
     */
    public function handle(ModifyTripEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
	        Mail::to($renter)->send(new ModifyTripRenterMail($event->trip));
        }
    }
}
