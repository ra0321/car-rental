<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\TripRequestOwnerMailEvent;
use App\Mail\TripMail\RequestTripOwnerMail;
use App\User;
use Mail;

/**
 * Class TripRequestOwnerMail
 * @package App\Listeners\NewMail
 */
class TripRequestOwnerMail
{
    /**
     * @param TripRequestOwnerMailEvent $event
     */
    public function handle(TripRequestOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new RequestTripOwnerMail($event->trip));
        }
    }
}
