<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\UpcomingTripOwnerMailEvent;
use App\Mail\TripMail\UpcomingTripOwnerMail as OwnerMail;
use App\User;
use Mail;

/**
 * Class UpcomingTripOwnerMail
 * @package App\Listeners\NewMail
 */
class UpcomingTripOwnerMail
{
    /**
     * @param UpcomingTripOwnerMailEvent $event
     */
    public function handle(UpcomingTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
