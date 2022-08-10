<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AcceptTripRequestOwnerMailEvent;
use App\Mail\TripMail\AcceptTripOwnerMail;
use App\User;
use Mail;

/**
 * Class AcceptTripRequestOwnerMailListener
 * @package App\Listeners\NewMail
 */
class AcceptTripRequestOwnerMailListener
{
    /**
     * @param AcceptTripRequestOwnerMailEvent $event
     */
    public function handle(AcceptTripRequestOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new AcceptTripOwnerMail($event->trip));
        }
    }
}
