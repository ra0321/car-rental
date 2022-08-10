<?php

namespace App\Mail\TripMail;

use App\Car;
use App\Traits\Arabic\ArabicNumbers;
use App\User;
use Illuminate\Mail\Mailable;

/**
 * Class RequestTripRenterMail
 * @package App\Mail\TripMail
 */
class RequestTripRenterMail extends Mailable
{
    use ArabicNumbers;

    /**
     * @var
     */
    public $trip;
    public $owner;
    public $car;
    public $production_year;

    /**
     * RequestTripRenterMail constructor.
     * @param $trip
     */
    public function __construct($trip)
    {
        $this->trip = $trip;
        $this->owner = User::findOrFail($trip->owner_id);
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
        return $this->subject('الحجز تحت الاجراء')->view('emails.trip.RequestTripMailRenter');
    }
}
