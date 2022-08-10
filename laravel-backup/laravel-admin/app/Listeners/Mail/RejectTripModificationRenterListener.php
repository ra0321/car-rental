<?php

namespace App\Listeners\Mail;

use App\Events\Mail\RejectTripModificationEvent;
use App\Mail\TripMail\RejectModificationTripRenterMail;
use App\User;
use Mail;

class RejectTripModificationRenterListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RejectTripModificationEvent  $event
     * @return void
     */
    public function handle(RejectTripModificationEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RejectModificationTripRenterMail($event->trip));
        }
    }
}
