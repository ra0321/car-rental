<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\RejectTripModificationRenterMailEvent;
use App\Mail\TripMail\RejectModificationTripRenterMail;
use App\User;
use Mail;

/**
 * Class RejectTripModificationRenterMail
 * @package App\Listeners\NewMail
 */
class RejectTripModificationRenterMail
{
    /**
     * @param RejectTripModificationRenterMailEvent $event
     */
    public function handle(RejectTripModificationRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RejectModificationTripRenterMail($event->trip));
        }
    }
}
