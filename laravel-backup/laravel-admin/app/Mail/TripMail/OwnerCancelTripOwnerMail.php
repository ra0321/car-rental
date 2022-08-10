<?php

namespace App\Mail\TripMail;

use App\Car;
use App\CarImage;
use App\CarRestriction;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\TripBill;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class OwnerCancelTripOwnerMail
 * @package App\Mail\TripMail
 */
class OwnerCancelTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

	/**
	 * @var Trip
	 */
	public $trip;
	public $renter;
	public $car;
	public $production_year;
	public $image;
	public $startDate;
	public $endDate;
	public $distance;
	public $tripTotal;
	public $ownerEarning;
	public $countryCode;
	public $phoneNumber;


	/**
	 * OwnerCancelTripOwnerMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
	    setlocale(LC_ALL, 'ar_AE.utf8');
        $this->trip = $trip;
	    $tripBills = TripBill::where('trip_id', $trip->id)->get();
	    $money = 0;
	    $total = 0;
	    foreach($tripBills as $k => $trip_bill){
		    $money += $trip_bill->owner_earning;
		    $total += $trip_bill->trip_total;
		    $this->ownerEarning = $this->en2ar($money);
		    $this->tripTotal = $this->en2ar($total);
	    }
        $this->renter = User::findOrFail($trip->renter_id);
        $this->car = Car::findOrFail($trip->car_id);
        $this->production_year = $this->en2ar($this->car->production_year);
	    $this->image = CarImage::where('car_id', $trip->car_id)->first();
	    $this->startDate = Carbon::parse($trip->start_date)->formatLocalized('%a %d. %b, %H:%M %p');
	    $this->endDate = Carbon::parse($trip->end_date)->formatLocalized('%a %d. %b, %H:%M %p');
	    $restriction = CarRestriction::where('car_id', $trip->car_id)->first();
	    $distanceKm = (string)$restriction->km_per_day;
	    $this->distance = $this->en2ar($distanceKm);
	    $this->phoneNumber = (string)$this->renter->phone_number;
	    $this->countryCode = (string)$this->renter->country_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('حجز ملغي')->view('emails.trip.OwnerCancelTripOwnerMail');
    }
}
