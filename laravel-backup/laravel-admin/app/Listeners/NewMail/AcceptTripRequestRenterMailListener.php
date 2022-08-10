<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AcceptTripRequestRenterEmailEvent;
use App\Mail\TripMail\AcceptTripRenterMail;
use App\User;
use Mail;

/**
 * Class AcceptTripRequestRenterMailListener
 * @package App\Listeners\NewMail
 */
class AcceptTripRequestRenterMailListener
{

    /**
     * @param AcceptTripRequestRenterEmailEvent $event
     */
    public function handle(AcceptTripRequestRenterEmailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new AcceptTripRenterMail($event->trip));
        }
    }
}
