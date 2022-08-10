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

/**
 * Class AcceptModificationTripOwnerMail
 * @package App\Mail\TripMail
 */
class AcceptModificationTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

	/**
	 * @var Trip
	 */
    public $trip;
	public $trip_bill;
    public $renter;
    public $car;
    public $production_year;
    public $startDate;
    public $endDate;
    public $airport;
	public $ownerEarning;
	public $tripTotal;

	/**
	 * AcceptModificationTripOwnerMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
	    setlocale(LC_ALL, 'ar_AE.utf8');
        $this->trip = $trip;
	    $this->trip_bill = TripBill::where('trip_id', $trip->id)->orderBy('created_at', 'desc')->first();
	    $this->ownerEarning = $this->en2ar($this->trip_bill->owner_earning);
	    $this->tripTotal = $this->en2ar($this->trip_bill->trip_total);
        $this->renter = User::findOrFail($trip->renter_id);
        $this->car = Car::findOrFail($trip->car_id);
        $this->production_year = $this->en2ar($this->car->production_year);
        $this->startDate = Carbon::parse($trip->start_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $this->endDate = Carbon::parse($trip->end_date)->formatLocalized('%a %d. %b, %H:%M %p');

        if(isset($trip->airport_id)){
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
        return $this->subject('طلب تعديل الحجز تم تأكيده')->view('emails.trip.AcceptModificationOwnerMail');
    }
}
