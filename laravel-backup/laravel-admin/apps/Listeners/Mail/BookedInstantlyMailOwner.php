<?php

namespace App\Listeners\Mail;

use App\Events\Mail\BookedInstantlyEvent;
use App\Mail\TripMail\BookInstantlyOwnerMail;
use App\User;
use Mail;

/**
 * Class BookedInstantlyMailOwner
 * @package App\Listeners\Mail
 */
class BookedInstantlyMailOwner
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
     * @param BookedInstantlyEvent $event
     */
    public function handle(BookedInstantlyEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        $renter = User::findOrFail($event->trip->renter_id);
        if($owner->email_promotions == true){
	        Mail::to($owner)->send(new BookInstantlyOwnerMail($event->trip, $renter));
        }
    }
}
