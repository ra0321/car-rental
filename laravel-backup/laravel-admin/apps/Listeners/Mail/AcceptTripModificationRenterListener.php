<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AcceptTripModificationEvent;
use App\Mail\TripMail\AcceptModificationTripRenterMail;
use App\User;
use Mail;

class AcceptTripModificationRenterListener
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
     * @param  AcceptTripModificationEvent  $event
     * @return void
     */
    public function handle(AcceptTripModificationEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new AcceptModificationTripRenterMail($event->trip));
        }
    }
}
