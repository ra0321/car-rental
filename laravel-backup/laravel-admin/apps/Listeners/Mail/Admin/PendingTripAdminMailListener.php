<?php

namespace App\Listeners\Mail\Admin;

use App\Events\Mail\Admin\PendingTripAdminEvent;
use App\Mail\Admin\PendingTripAdminMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class PendingTripAdminMailListener
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
     * @param  PendingTripAdminEvent  $event
     * @return void
     */
    public function handle(PendingTripAdminEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new PendingTripAdminMail($event->trip));
    }
}
