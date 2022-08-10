<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\TripRejectedOwnerMailEvent;
use App\Mail\TripMail\RejectTripOwnerMail;
use App\User;
use Mail;

/**
 * Class TripRejectedOwnerMail
 * @package App\Listeners\NewMail
 */
class TripRejectedOwnerMail
{
    /**
     * @param TripRejectedOwnerMailEvent $event
     */
    public function handle(TripRejectedOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new RejectTripOwnerMail($event->trip));
        }
    }
}
