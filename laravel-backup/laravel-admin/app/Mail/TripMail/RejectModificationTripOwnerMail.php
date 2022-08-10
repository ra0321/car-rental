<?php

namespace App\Mail\TripMail;

use App\Car;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\TripBill;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class RejectModificationTripOwnerMail
 * @package App\Mail\TripMail
 */
class RejectModificationTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

	/**
	 * @var Trip
	 */
    public $trip;
    public $trip_bill;
    public $ownerEarning;
    public $renter;
    public $car;
    public $production_year;

	/**
	 * RejectModificationTripOwnerMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->trip_bill = TripBill::where('trip_id', $this->trip->id)->first();
        $this->ownerEarning = $this->en2ar($this->trip_bill->owner_earning);
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
        return $this->subject('طلب تعديل الحجز تم رفضه')->view('emails.trip.RejectModificationTripOwnerMail');
    }
}
