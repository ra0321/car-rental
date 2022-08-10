<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\UpcomingTripRenterMailEvent;
use App\Mail\TripMail\UpcomingTripRenterMail as RenterMail;
use App\User;
use Mail;

/**
 * Class UpcomingTripRenterMail
 * @package App\Listeners\NewMail
 */
class UpcomingTripRenterMail
{
    /**
     * @param UpcomingTripRenterMailEvent $event
     */
    public function handle(UpcomingTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RenterMail($event->trip));
        }
    }
}
