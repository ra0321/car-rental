<?php

namespace App\Listeners\Mail\Admin;

use App\Events\Mail\Admin\BookedInstantlyAdminEvent;
use App\Mail\Admin\BookedInstantlyAdminMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class BookInstantlyAdminMailListener
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
     * @param  BookedInstantlyAdminEvent  $event
     * @return void
     */
    public function handle(BookedInstantlyAdminEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new BookedInstantlyAdminMail($event->trip));
    }
}
