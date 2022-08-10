<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\ModifyTripRenterMailEvent;
use App\Mail\TripMail\ModifyTripRenterMail as RenterMail;
use App\User;
use Mail;

/**
 * Class ModifyTripRenterMail
 * @package App\Listeners\NewMail
 */
class ModifyTripRenterMail
{
    /**
     * @param ModifyTripRenterMailEvent $event
     */
    public function handle(ModifyTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RenterMail($event->trip));
        }
    }
}
