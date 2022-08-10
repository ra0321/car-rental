<?php

namespace App\Mail\TripMail;

use App\Car;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


/**
 * Class CancelWithinHourRenterMail
 * @package App\Mail\TripMail
 */
class CancelWithinHourRenterMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

	/**
	 * @var Trip
	 */
    public $trip;
    public $owner;
    public $car;

	/**
	 * CancelWithinHourRenterMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->owner = User::findOrFail($trip->owner_id);
        $this->car = Car::findOrFail($trip->car_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('حجز ملغي')->view('emails.trip.CancelWithinHourRenterMail');
    }
}
