<?php

namespace App\Mail\TripMail;

use App\Car;
use App\CarAirport;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\TripBill;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class RenterCancelTripOwnerMail
 * @package App\Mail\TripMail
 */
class RenterCancelTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels,ArabicNumbers;

	/**
	 * @var
	 */
	public $trip;
	public $renter;
	public $car;
	public $airport;
	public $tripBill;
    public $startDate;
    public $endDate;
    public $production_year;

	/**
	 * RenterCancelTripOwnerMail constructor.
	 *
	 * @param $trip
	 */
	public function __construct(Trip $trip)
    {
	    setlocale(LC_ALL, 'ar_AE.utf8');
    	$this->trip = $trip;
    	$this->renter = User::findOrFail($this->trip->renter_id);
    	$this->car = Car::findOrFail($this->trip->car_id);
    	$this->tripBill = TripBill::whereTripId($trip->id)->get()->all();
    	if(isset($trip->delivery_on_airport) && $trip->delivery_on_airport === 1){
    		$this->airport = CarAirport::findOrFail($trip->airport_id);
	    }
        $this->startDate = Carbon::parse($trip->start_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $this->endDate = Carbon::parse($trip->end_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $this->production_year = $this->en2ar($this->car->production_year);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تم إلغاء الحجز')->view('emails.trip.RenterCancelTripOwnerMail');
    }
}
