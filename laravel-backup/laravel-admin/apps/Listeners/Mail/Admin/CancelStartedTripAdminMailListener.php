<?php

namespace App\Listeners\Mail\Admin;

use App\Events\Mail\Admin\CancelStartedTripAdminEvent;
use App\Mail\Admin\CancelStartedTripAdminMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class CancelStartedTripAdminMailListener
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
     * @param  CancelStartedTripAdminEvent  $event
     * @return void
     */
    public function handle(CancelStartedTripAdminEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new CancelStartedTripAdminMail($event->trip));
    }
}
