<?php

namespace App\Mail\TripMail;

use App\Car;
use App\CarAirport;
use App\CarImage;
use App\CarRestriction;
use App\ChatMessage;
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
 * Class RequestTripOwnerMail
 * @package App\Mail\TripMail
 */
class RequestTripOwnerMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

    /**
     * @var
     */
    public $trip;
    /**
     * @var
     */
    public $tripBill;
    public $owner;
    public $renter;
    public $car;
    public $chatMessage;
    public $distance;
    public $image;
    public $airport;
    public $startDate;
    public $endDate;
    public $ownerEarning;
    public $kmPerDay;
    public $tripTotal;
    public $phoneNumber;
    public $countryCode;

    /**
     * RequestTripOwnerMail constructor.
     * @param $trip
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
        $this->owner = User::with('profile')->findOrFail($trip->owner_id);
        $this->renter = User::with('profile')->findOrFail($trip->renter_id);
        $this->car = Car::findOrFail($trip->car_id);
        if(isset($trip->airport_id)){
        	$this->airport = CarAirport::findOrFail($trip->airport_id);
        }
        $this->image = CarImage::where('car_id', $trip->car_id)->first();
        $restriction = CarRestriction::where('car_id', $trip->car_id)->first();
        $this->chatMessage = ChatMessage::where('chat_id', $trip->chat_id)
	        ->orderBy('created_at', 'desc')
	        ->first();
	    $distanceKm = (string)$restriction->km_per_day;
	    $this->phoneNumber = (string)$this->renter->phone_number;
	    $this->countryCode = (string)$this->renter->country_code;
	    $this->distance = $this->en2ar($distanceKm);
        $this->startDate = Carbon::parse($trip->start_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $this->endDate = Carbon::parse($trip->end_date)->formatLocalized('%a %d. %b, %H:%M %p');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('حجز تحت الاجراء')->view('emails.trip.RequestTripMailOwner');
    }
}
