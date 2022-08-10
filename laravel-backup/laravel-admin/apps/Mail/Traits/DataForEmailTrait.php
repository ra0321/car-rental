<?php

namespace App\Mail\Traits;

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

/**
 * Trait DataForEmailTrait
 * @package App\Mail\Traits
 */
trait DataForEmailTrait
{
    use ArabicNumbers;

    /**
     * @param Trip $trip
     * @return array
     */
    public function dataForEmail(Trip $trip)
    {
        setlocale(LC_ALL, 'ar_AE.utf8');
        $tripBills = TripBill::where('trip_id', $trip->id)->get();
        $money = 0;
        $total = 0;
        foreach($tripBills as $k => $trip_bill){
            $money += $trip_bill->owner_earning;
            $total += $trip_bill->trip_total;
            $ownerEarning = $this->en2ar($money);
            $tripTotal = $this->en2ar($total);
        }
        $owner = User::with('profile')->findOrFail($trip->owner_id);
        $renter = User::with('profile')->findOrFail($trip->renter_id);
        $car = Car::findOrFail($trip->car_id);
        if(isset($trip->airport_id)){
            $airport = CarAirport::findOrFail($trip->airport_id);
        }
        $image = CarImage::where('car_id', $trip->car_id)->first();
        $restriction = CarRestriction::where('car_id', $trip->car_id)->first();
        $chatMessage = ChatMessage::where('chat_id', $trip->chat_id)
            ->orderBy('created_at', 'desc')
            ->first();
        $distanceKm = (string)$restriction->km_per_day;
        $phoneNumber = (string)$renter->phone_number;
        $countryCode = (string)$renter->country_code;
        $distance = $this->en2ar($distanceKm);
        $startDate = Carbon::parse($trip->start_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $endDate = Carbon::parse($trip->end_date)->formatLocalized('%a %d. %b, %H:%M %p');
        $production_year = $this->en2ar($car->production_year);

        return [
            'ownerEarning' => isset($ownerEarning) ? $ownerEarning : null,
            'tripTotal' => isset($tripTotal) ? $tripTotal : null,
            'airport' => isset($airport) ? $airport : null,
            'owner' => $owner,
            'renter' => $renter,
            'car' => $car,
            'chatMessage' => $chatMessage,
            'distance' => $distance,
            'image' => $image,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'kmPerDay' => $distance,
            'phoneNumber' => $phoneNumber,
            'countryCode' => $countryCode,
            'productionYear' => $production_year,
        ];
    }
}