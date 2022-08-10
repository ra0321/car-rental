<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\TripRequestRenterMailEvent;
use App\Mail\TripMail\RequestTripRenterMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class TripRequestRenterMail
{
    /**
     * Handle the event.
     *
     * @param  TripRequestRenterMailEvent  $event
     * @return void
     */
    public function handle(TripRequestRenterMailEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new RequestTripRenterMail($event->trip));
        }
    }
}
