<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\CancelWithinHourTripOwnerMailEvent;
use App\Mail\TripMail\CancelWithinHourOwnerMail;
use App\User;
use Mail;

/**
 * Class CancelWithinHourTripOwnerMail
 * @package App\Listeners\NewMail
 */
class CancelWithinHourTripOwnerMail
{
    /**
     * @param CancelWithinHourTripOwnerMailEvent $event
     */
    public function handle(CancelWithinHourTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new CancelWithinHourOwnerMail($event->trip));
        }
    }
}
