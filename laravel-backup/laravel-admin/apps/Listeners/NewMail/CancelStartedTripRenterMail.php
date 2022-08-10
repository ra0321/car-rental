<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\CancelStartedTripRenterMailEvent;
use App\Mail\TripMail\CancelStartedTripRenterMail as RenterMail;
use App\User;
use Mail;

/**
 * Class CancelStartedTripRenterMail
 * @package App\Listeners\NewMail
 */
class CancelStartedTripRenterMail
{
    /**
     * @param CancelStartedTripRenterMailEvent $event
     */
    public function handle(CancelStartedTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RenterMail($event->trip));
        }
    }
}
