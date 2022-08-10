<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\TripEndsSoonRenterMailEvent;
use App\Mail\TripMail\TripEndsSoonMailRenter as RenterMail;
use App\User;
use Mail;

/**
 * Class TripEndsSoonRenterMail
 * @package App\Listeners\NewMail
 */
class TripEndsSoonRenterMail
{
    /**
     * @param TripEndsSoonRenterMailEvent $event
     */
    public function handle(TripEndsSoonRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RenterMail($event->trip));
        }
    }
}
