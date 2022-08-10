<?php

namespace App\Listeners\Mail;

use App\Events\Mail\AcceptTripModificationEvent;
use App\Mail\TripMail\AcceptModificationTripOwnerMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class AcceptTripModificationOwnerListener
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
     * @param  AcceptTripModificationEvent  $event
     * @return void
     */
    public function handle(AcceptTripModificationEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new AcceptModificationTripOwnerMail($event->trip));
        }
    }
}
