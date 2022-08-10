<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\ModifyTripOwnerMailEvent;
use App\Mail\TripMail\ModifyTripOwnerMail as OwnerMail;
use App\User;
use Mail;

/**
 * Class ModifyTripOwnerMail
 * @package App\Listeners\NewMail
 */
class ModifyTripOwnerMail
{
    /**
     * @param ModifyTripOwnerMailEvent $event
     */
    public function handle(ModifyTripOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new OwnerMail($event->trip));
        }
    }
}
