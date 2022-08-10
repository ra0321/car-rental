<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AcceptTripModificationRenterMailEvent;
use App\Mail\TripMail\AcceptModificationTripRenterMail;
use App\User;
use Mail;

/**
 * Class AcceptTripModificationRenterMail
 * @package App\Listeners\NewMail
 */
class AcceptTripModificationRenterMail
{
    /**
     * @param AcceptTripModificationRenterMailEvent $event
     */
    public function handle(AcceptTripModificationRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new AcceptModificationTripRenterMail($event->trip));
        }
    }
}
