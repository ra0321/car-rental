<?php

namespace App\Listeners\Mail\Admin;

use App\Events\Mail\Admin\TripRejectedAdminEvent;
use App\Mail\Admin\TripRejectedAdminMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class TripRejectedAdminMailListener
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
     * @param  TripRejectedAdminEvent  $event
     * @return void
     */
    public function handle(TripRejectedAdminEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new TripRejectedAdminMail($event->trip));
    }
}
