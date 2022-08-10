<?php

namespace App\Mail\AntiFraud;

use App\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class RenterAntiFraudTripMail
 * @package App\Mail\AntiFraud
 */
class RenterAntiFraudTripMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * RenterAntiFraudTripMail constructor.
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
        return $this->subject('Anti Fraud Transaction')->view('emails.antiFraud.RenterAntiFraudMail');
    }
}
