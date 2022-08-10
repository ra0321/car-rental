<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\AutoCancelTripModificationRenterMailEvent;
use App\Mail\TripMail\AutoCancelModificationRenterMail;
use App\User;
use Mail;

/**
 * Class AutoCancelTripModificationRenterMail
 * @package App\Listeners\NewMail
 */
class AutoCancelTripModificationRenterMail
{
    /**
     * @param AutoCancelTripModificationRenterMailEvent $event
     */
    public function handle(AutoCancelTripModificationRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true) {
            Mail::to( $renter )->send( new AutoCancelModificationRenterMail( $event->trip ) );
        }
    }
}
