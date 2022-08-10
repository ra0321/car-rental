<?php

namespace App\Listeners\Mail\Admin;

use App\Events\Mail\Admin\RenterCancelTripAdminEvent;
use App\Mail\Admin\RenterCancelTripAdminMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class RenterCancelTripAdminMailListener
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
     * @param  RenterCancelTripAdminEvent  $event
     * @return void
     */
    public function handle(RenterCancelTripAdminEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new RenterCancelTripAdminMail($event->trip));
    }
}
