<?php

namespace App\Listeners\Mail\AntiFraud;

use App\Events\Mail\AntiFraud\AdminCanceledAntiFraudTransactionEvent;
use App\Mail\AntiFraud\AdminCanceledAntiFraudTransactionMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class AdminCanceledAntiFraudTransactionMailListener
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
     * @param  AdminCanceledAntiFraudTransactionEvent  $event
     * @return void
     */
    public function handle(AdminCanceledAntiFraudTransactionEvent $event)
    {
        Mail::to(config('values.admin_email'))->send(new AdminCanceledAntiFraudTransactionMail($event->trip));
    }
}
