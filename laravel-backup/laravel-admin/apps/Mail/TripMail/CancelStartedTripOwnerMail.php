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
 * Class CancelStartedTripOwnerMail
 * @package App\Mail\TripMail
 */
class CancelStartedTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

	/**
	 * @var Trip
	 */
	public $trip;
	public $renter;
    public $startDate;
    public $endDate;
    public $airport;
    public $car;
    public $production_year;


	/**
	 * CancelStartedTripOwnerMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        setlocale(LC_ALL, 'ar_AE.utf8');
        $this->trip = $trip;
        $this->renter = User::findOrFail($trip->renter_id);
        $this->startDate = Carbon::parse($trip->start_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $this->endDate = Carbon::parse($trip->end_date)->formatLocalized('%a %d. %b, %H:%M %p');
        if(isset($trip->airport_id)){
            $this->airport = CarAirport::findOrFail($trip->airport_id);
        }
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
        return $this->subject('تم إلغاء الحجز')->view('emails.trip.CancelStartedTripOwnerMail');
    }
}
