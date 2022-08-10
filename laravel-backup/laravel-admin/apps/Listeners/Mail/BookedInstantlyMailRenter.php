<?php

namespace App\Listeners\Mail;

use App\Events\Mail\BookedInstantlyEvent;
use App\Mail\TripMail\BookInstantlyRenterMail;
use App\User;
use Mail;

class BookedInstantlyMailRenter
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
     * @param  BookedInstantlyEvent  $event
     * @return void
     */
    public function handle(BookedInstantlyEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        if($renter->email_promotions == true){
	        Mail::to($renter)->send(new BookInstantlyRenterMail($event->trip));
        }
    }
}
