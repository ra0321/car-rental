<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\OwnerCancelTripOwnerMailEvent;
use App\Mail\TripMail\OwnerCancelTripOwnerMail as OwnerMail;
use App\User;
use Mail;

/**
 * Class OwnerCancelTripOwnerMail
 * @package App\Listeners\NewMail
 */
class OwnerCancelTripOwnerMail
{
    /**
     * @param OwnerCancelTripOwnerMailEvent $event
     */
    public function handle(OwnerCancelTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
