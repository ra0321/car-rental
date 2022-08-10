<?php

namespace App\Mail\TripMail;

use App\Car;
use App\CarAirport;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class CancelWithinHourOwnerMail
 * @package App\Mail\TripMail
 */
class CancelWithinHourOwnerMail extends Mailable
{
    use Queueable, SerializesModels,  ArabicNumbers;

	/**
	 * @var Trip
	 */
	public $trip;
	public $renter;
    public $car;
    public $startDate;
    public $endDate;
    public $production_year;
	public $airport;



	/**
	 * CancelWithinHourOwnerMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->renter = User::findOrFail($trip->renter_id);
        $this->car = Car::findOrFail($trip->car_id);
        $this->startDate = Carbon::parse($trip->start_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $this->endDate = Carbon::parse($trip->end_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $this->production_year = $this->en2ar($this->car->production_year);
	    if(isset($trip->delivery_on_airport) && $trip->delivery_on_airport === 1){
		    $this->airport = CarAirport::findOrFail($trip->airport_id);
	    }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('حجز ملغي')->view('emails.trip.CancelWithinHourOwnerMail');
    }
}
