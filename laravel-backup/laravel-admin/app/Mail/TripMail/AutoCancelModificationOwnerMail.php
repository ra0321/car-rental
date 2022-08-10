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
 * Class AutoCancelModificationOwnerMail
 * @package App\Mail\TripMail
 */
class AutoCancelModificationOwnerMail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Trip
	 */
	public $trip;
	public $renter;
	public $car;

	/**
	 * AutoCancelModificationOwnerMail constructor.
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
        return $this->subject('تم رفض الحجز')->view('emails.trip.AutoCancelModificationOwnerMail');
    }
}
