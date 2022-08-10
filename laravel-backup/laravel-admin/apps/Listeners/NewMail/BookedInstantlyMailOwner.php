<?php

namespace App\Listeners\NewMail;

use App\Events\NewMail\BookedInstantlyOwnerMailEvent;
use App\Mail\TripMail\BookInstantlyOwnerMail;
use App\User;
use Mail;

class BookedInstantlyMailOwner
{
    /**
     * Handle the event.
     *
     * @param  BookedInstantlyOwnerMailEvent  $event
     * @return void
     */
    public function handle(BookedInstantlyOwnerMailEvent $event)
    {
        $owner = User::findOrFail($event->trip->owner_id);
        if($owner->email_promotions == true){
            Mail::to($owner)->send(new BookInstantlyOwnerMail($event->trip));
        }
    }
}
