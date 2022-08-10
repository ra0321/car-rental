<?php

namespace App\Listeners\User;

use Mail;
use App\Mail\VerifyEmail;
use App\Events\User\CreateUser;

class SendVerificationMail
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
     * @param  CreateUser  $event
     * @return void
     */
    public function handle(CreateUser $event)
    {
	    Mail::to($event->user)->send(new VerifyEmail($event->user));
    }
}
