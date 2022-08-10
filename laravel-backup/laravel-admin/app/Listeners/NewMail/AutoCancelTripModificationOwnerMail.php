<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AutoCancelTripModificationOwnerMailEvent;
use App\Mail\TripMail\AutoCancelModificationOwnerMail;
use App\User;
use Mail;

/**
 * Class AutoCancelTripModificationOwnerMail
 * @package App\Listeners\NewMail
 */
class AutoCancelTripModificationOwnerMail
{
    /**
     * @param AutoCancelTripModificationOwnerMailEvent $event
     */
    public function handle(AutoCancelTripModificationOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new AutoCancelModificationOwnerMail($event->trip));
        }
    }
}
