<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\TripEndsSoonOwnerMailEvent;
use App\Mail\TripMail\TripEndsSoonMailOwner as OwnerMail;
use App\User;
use Mail;

/**
 * Class TripEndsSoonOwnerMail
 * @package App\Listeners\NewMail
 */
class TripEndsSoonOwnerMail
{
    /**
     * @param TripEndsSoonOwnerMailEvent $event
     */
    public function handle(TripEndsSoonOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
