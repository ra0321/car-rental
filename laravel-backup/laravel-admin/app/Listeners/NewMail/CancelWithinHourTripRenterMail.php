<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\CancelWithinHourTripRenterMailEvent;
use App\Mail\TripMail\CancelWithinHourRenterMail;
use App\User;
use Mail;

/**
 * Class CancelWithinHourTripRenterMail
 * @package App\Listeners\NewMail
 */
class CancelWithinHourTripRenterMail
{
    /**
     * @param CancelWithinHourTripRenterMailEvent $event
     */
    public function handle(CancelWithinHourTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new CancelWithinHourRenterMail($event->trip));
        }
    }
}
