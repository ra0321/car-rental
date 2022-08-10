<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\CancelStartedTripOwnerMailEvent;
use App\Mail\TripMail\CancelStartedTripOwnerMail as OwnerMail;
use App\User;
use Mail;

/**
 * Class CancelStartedTripOwnerMail
 * @package App\Listeners\NewMail
 */
class CancelStartedTripOwnerMail
{
    /**
     * @param CancelStartedTripOwnerMailEvent $event
     */
    public function handle(CancelStartedTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
