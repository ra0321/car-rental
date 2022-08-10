<?php

namespace App\Listeners\Mail\Admin;

use App\Events\Mail\Admin\ModificationTripAdminEvent;
use App\Mail\Admin\ModificationTripAdminMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class ModificationTripAdminMailListener
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
     * @param  ModificationTripAdminEvent  $event
     * @return void
     */
    public function handle(ModificationTripAdminEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new ModificationTripAdminMail($event->trip));
    }
}
