<?php

namespace App\Mail\TripMail;

use App\Car;
use App\CarAirport;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

class RejectModificationTripRenterMail extends Mailable
{
    use Queueable, SerializesModels,  ArabicNumbers;

	public $trip;
    public $owner;
    public $airport;
    public $car;

    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->owner = User::with('profile')->findOrFail($trip->owner_id);
        if(isset($trip->airport_id)){
            $this->airport = CarAirport::findOrFail($trip->airport_id);
        }
        $this->car = Car::findOrFail($trip->car_id);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('طلب تعديل الحجز تم رفضه')->view('emails.trip.RejectModificationTripRenterMail');
    }
}
