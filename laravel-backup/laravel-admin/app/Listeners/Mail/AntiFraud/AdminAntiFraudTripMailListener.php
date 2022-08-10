<?php

namespace App\Listeners\Mail\AntiFraud;

use App\Events\Mail\AntiFraud\AdminAntiFraudTripEvent;
use App\Mail\AntiFraud\AdminAntiFraudTripMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class AdminAntiFraudTripMailListener
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
     * @param  AdminAntiFraudTripEvent  $event
     * @return void
     */
    public function handle(AdminAntiFraudTripEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new AdminAntiFraudTripMail($event->trip));
    }
}
