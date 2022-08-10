<?php

namespace App\Mail\TripMail;

use App\Car;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class ModifyTripRenterMail
 * @package App\Mail\TripMail
 */
class ModifyTripRenterMail extends Mailable
{
    use Queueable, SerializesModels,ArabicNumbers;

	/**
	 * @var Trip
	 */
	public $trip;
    public $owner;
    public $car;
    public $production_year;

	/**
	 * ModifyTripRenterMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->owner = User::findOrFail($trip->owner_id);
        $this->car =  Car::findOrFail($trip->car_id);
        $this->production_year = $this->en2ar($this->car->production_year);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('طلب تعديل الحجز تحت الاجراء')->view('emails.trip.ModifyTripRenterMail');
    }
}
