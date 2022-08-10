<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AcceptTripRequestEvent;
use App\Mail\TripMail\AcceptTripRenterMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class AcceptTripRequestMailRenterListener
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
     * @param  AcceptTripRequestEvent  $event
     * @return void
     */
    public function handle(AcceptTripRequestEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new AcceptTripRenterMail($event->trip));
        }
    }
}
