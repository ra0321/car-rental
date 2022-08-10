<?php

namespace App\Listeners\Mail;

use App\Events\Mail\CancelWithinHourTripEvent;
use App\Mail\TripMail\CancelWithinHourRenterMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class CancelWithinHourTripMailRenterListener
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
     * @param  CancelWithinHourTripEvent  $event
     * @return void
     */
    public function handle(CancelWithinHourTripEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
            Mail::to($renter)->send(new CancelWithinHourRenterMail($event->trip));
        }
    }
}
