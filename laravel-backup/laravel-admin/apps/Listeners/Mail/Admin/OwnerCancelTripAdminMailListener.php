<?php

namespace App\Listeners\Mail\Admin;

use App\Events\Mail\Admin\OwnerCancelTripAdminEvent;
use App\Mail\Admin\OwnerCancelTripAdminMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class OwnerCancelTripAdminMailListener
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
     * @param  OwnerCancelTripAdminEvent  $event
     * @return void
     */
    public function handle(OwnerCancelTripAdminEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new OwnerCancelTripAdminMail($event->trip));
    }
}
