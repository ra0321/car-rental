<?php

namespace App\Mail\AntiFraud;

use App\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCanceledAntiFraudTransactionRenterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * AdminCanceledAntiFraudTransactionRenterMail constructor.
     * @param Trip $trip
     */
    public function __construct(Trip $trip)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Admin canceled anti fraud transaction')->view('emails.antiFraud.AdminCanceledAntiFraudTransactionRenterMail');
    }
}
