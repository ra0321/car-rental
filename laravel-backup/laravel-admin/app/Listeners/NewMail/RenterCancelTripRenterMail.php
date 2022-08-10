<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\RenterCancelTripRenterMailEvent;
use App\Mail\TripMail\RenterCancelTripRenterMail as RenterMail;
use App\User;
use Mail;

/**
 * Class RenterCancelTripRenterMail
 * @package App\Listeners\NewMail
 */
class RenterCancelTripRenterMail
{
    /**
     * @param RenterCancelTripRenterMailEvent $event
     */
    public function handle(RenterCancelTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RenterMail($event->trip));
        }
    }
}
