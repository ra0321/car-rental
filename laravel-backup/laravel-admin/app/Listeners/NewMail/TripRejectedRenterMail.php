<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\TripRejectedRenterMailEvent;
use App\Mail\TripMail\RejectTripRenterMail;
use App\User;
use Mail;

/**
 * Class TripRejectedRenterMail
 * @package App\Listeners\NewMail
 */
class TripRejectedRenterMail
{
    /**
     * @param TripRejectedRenterMailEvent $event
     */
    public function handle(TripRejectedRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RejectTripRenterMail($event->trip));
        }
    }
}
