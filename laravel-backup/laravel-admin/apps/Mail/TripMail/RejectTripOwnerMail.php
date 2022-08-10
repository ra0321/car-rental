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
 * Class RejectTripOwnerMail
 * @package App\Mail\TripMail
 */
class RejectTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;
	/**
	 * @var Trip
	 */
    public $trip;
    public $renter;
    public $car;
    public $production_year;

	/**
	 * RejectTripOwnerMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->renter = User::findOrFail($trip->renter_id);
        $this->car = Car::findOrFail($trip->car_id);
        $this->production_year = $this->en2ar($this->car->production_year);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('حجز مرفوض')->view('emails.trip.RejectTripOwnerMail');
    }
}
