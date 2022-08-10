<?php

namespace App\Mail\TripMail;

use App\Car;
use App\Trip;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class AutoCancelTripOwnerMail
 * @package App\Mail\TripMail
 */
class AutoCancelTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Trip
	 */
	public $trip;
	public $renter;
	public $car;

	/**
	 * AutoCancelTripOwnerMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->renter = User::findOrFail($trip->renter_id);
        $this->car = Car::findOrFail($trip->car_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('حجز مرفوض')->view('emails.trip.AutoCancelTripOwnerMail');
    }
}
