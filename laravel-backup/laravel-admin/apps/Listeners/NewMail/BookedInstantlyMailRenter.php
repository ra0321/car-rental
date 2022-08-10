<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\BookedInstantlyRenterMailEvent;
use App\Mail\TripMail\BookInstantlyRenterMail;
use App\User;
use Mail;

class BookedInstantlyMailRenter
{
    /**
     * Handle the event.
     *
     * @param  BookedInstantlyRenterMailEvent  $event
     * @return void
     */
    public function handle(BookedInstantlyRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new BookInstantlyRenterMail($event->trip));
        }
    }
}
