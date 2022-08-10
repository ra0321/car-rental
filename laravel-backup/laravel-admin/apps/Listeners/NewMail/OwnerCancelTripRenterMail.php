<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\OwnerCancelTripRenterMailEvent;
use App\Mail\TripMail\OwnerCancelTripRenterMail as RenterMail;
use App\User;
use Mail;

/**
 * Class OwnerCancelTripRenterMail
 * @package App\Listeners\NewMail
 */
class OwnerCancelTripRenterMail
{
    /**
     * @param OwnerCancelTripRenterMailEvent $event
     */
    public function handle(OwnerCancelTripRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true) {
            Mail::to( $renter )->send( new RenterMail( $event->trip ) );
        }
    }
}
