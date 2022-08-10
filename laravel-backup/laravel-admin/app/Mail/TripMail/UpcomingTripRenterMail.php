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

class UpcomingTripRenterMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

    public $trip;
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
    public $production_year;

    public function __construct(Trip $trip)
    {
        setlocale(LC_ALL, 'ar_AE.utf8');
        $this->trip = $trip;
        $this->tripBill = TripBill::where('trip_id', $trip->id)->first();
        $this->owner = User::with('profile')->findOrFail($trip->owner_id);
        $this->renter = User::with('profile')->findOrFail($trip->renter_id);
        $this->car = Car::findOrFail($trip->car_id);
        if(isset($trip->airport_id)){
            $this->airport = CarAirport::findOrFail($trip->airport_id);
        }
        $this->image = CarImage::where('car_id', $trip->car_id)->first();
        $this->distance = CarRestriction::where('car_id', $trip->car_id)->first();
        $this->chatMessage = ChatMessage::where('chat_id', $trip->chat_id)
            ->orderBy('created_at', 'desc')
            ->first();
        $ownerMoney = (string)$this->tripBill->owner_earning;
        $distanceKm = (string)$this->distance->km_per_day;
        $total = (string)$this->tripBill->trip_total;
	    $this->phoneNumber = (string)$this->owner->phone_number;
	    $this->countryCode = (string)$this->owner->country_code;
        $this->tripTotal = $this->en2ar($total);
        $this->kmPerDay = $this->en2ar($distanceKm);
        $this->ownerEarning = $this->en2ar($ownerMoney);
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
        return $this->subject('رحلتك تبدأ غداً')->view('emails.trip.UpcomingTripRenterMail');
    }
}
