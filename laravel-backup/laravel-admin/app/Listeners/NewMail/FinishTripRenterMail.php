<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\FinishTripRenterMailEvent;
use App\Mail\TripMail\FinishTripRenterMail as RenterMail;
use App\User;
use Mail;

/**
 * Class FinishTripRenterMail
 * @package App\Listeners\NewMail
 */
class FinishTripRenterMail
{
    /**
     * @param FinishTripRenterMailEvent $event
     */
    public function handle(FinishTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true) {
            Mail::to($renter)->send(new RenterMail($event->trip));
        }
    }
}
