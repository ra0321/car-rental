<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AutoCancelTripOwnerMailEvent;
use App\Mail\TripMail\AutoCancelTripOwnerMail as OwnerMail;
use App\User;
use Mail;

/**
 * Class AutoCancelTripOwnerMail
 * @package App\Listeners\NewMail
 */
class AutoCancelTripOwnerMail
{
    /**
     * @param AutoCancelTripOwnerMailEvent $event
     */
    public function handle(AutoCancelTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
