<?php

namespace App\Listeners\Mail\AntiFraud;

use App\Events\Mail\AntiFraud\AdminCanceledAntiFraudTransactionRenterEvent;
use App\Mail\AntiFraud\AdminCanceledAntiFraudTransactionRenterMail;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class AdminCanceledAntiFraudTransactionRenterMailListener
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
     * @param  AdminCanceledAntiFraudTransactionRenterEvent  $event
     * @return void
     */
    public function handle(AdminCanceledAntiFraudTransactionRenterEvent $event)
    {
        $renter = User::findOrFail($event->trip->renter_id);
        Mail::to($renter->email)->send(new AdminCanceledAntiFraudTransactionRenterMail($event->trip));
    }
}
