<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\FinishTripOwnerMailEvent;
use App\Mail\TripMail\FinishTripOwnerMail as OwnerMail;
use App\User;
use Mail;

/**
 * Class FinishTripOwnerMail
 * @package App\Listeners\NewMail
 */
class FinishTripOwnerMail
{
    /**
     * @param FinishTripOwnerMailEvent $event
     */
    public function handle(FinishTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
