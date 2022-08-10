<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\RejectTripModificationOwnerMailEvent;
use App\Mail\TripMail\RejectModificationTripOwnerMail;
use App\User;
use Mail;

/**
 * Class RejectTripModificationOwnerMail
 * @package App\Listeners\NewMail
 */
class RejectTripModificationOwnerMail
{
    /**
     * @param RejectTripModificationOwnerMailEvent $event
     */
    public function handle(RejectTripModificationOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new RejectModificationTripOwnerMail($event->trip));
        }
    }
}
