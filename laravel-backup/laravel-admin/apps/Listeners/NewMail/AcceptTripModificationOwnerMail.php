<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AcceptTripModificationOwnerMailEvent;
use App\Mail\TripMail\AcceptModificationTripOwnerMail;
use App\User;
use Mail;

/**
 * Class AcceptTripModificationOwnerMail
 * @package App\Listeners\NewMail
 */
class AcceptTripModificationOwnerMail
{
    /**
     * @param AcceptTripModificationOwnerMailEvent $event
     */
    public function handle(AcceptTripModificationOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new AcceptModificationTripOwnerMail($event->trip));
        }
    }
}
