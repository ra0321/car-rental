<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AutoCancelTripRenterMailEvent;
use App\Mail\TripMail\AutoCancelTripRenterMail as RenterMail;
use App\User;
use Mail;

/**
 * Class AutoCancelTripRenterMail
 * @package App\Listeners\NewMail
 */
class AutoCancelTripRenterMail
{
    /**
     * @param AutoCancelTripRenterMailEvent $event
     */
    public function handle(AutoCancelTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RenterMail($event->trip));
        }
    }
}
