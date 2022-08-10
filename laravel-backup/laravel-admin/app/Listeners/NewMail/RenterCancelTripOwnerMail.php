<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\RenterCancelTripOwnerMailEvent;
use App\Mail\TripMail\RenterCancelTripOwnerMail as OwnerMail;
use App\User;
use Mail;

/**
 * Class RenterCancelTripOwnerMail
 * @package App\Listeners\NewMail
 */
class RenterCancelTripOwnerMail
{
    /**
     * @param RenterCancelTripOwnerMailEvent $event
     */
    public function handle(RenterCancelTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
