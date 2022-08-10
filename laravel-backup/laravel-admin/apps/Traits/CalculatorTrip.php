<?php

namespace App\Traits;

use App\BookInstantly;
use App\CarAirport;
use App\CustomPrice;
use App\Exceptions\CustomException;
use App\Exceptions\DynamicException;
use App\TripBill;
use Carbon\Carbon;

/**
 * Trait CalculatorTrip
 * @package App\Traits
 */
trait CalculatorTrip
{
    use Distances, ValueTransform;

    /**
     * @param $data
     * @return TripBill
     * @throws DynamicException
     */
    public function tripPriceCalculationTwoDec($data)
    {
        $shortest_trip = $this->shortestTrip($data['car']->short_trip, $data);
        $longest_trip = $this->longestTrip($data['car']->long_trip, $data);

        if(count($data['priceByDay']) > $longest_trip){
            throw new DynamicException(LONGEST_TRIP_FOR_THIS_CAR_IS, $data['car']->long_trip);
        }
        if(count($data['priceByDay']) < $shortest_trip){
            throw new DynamicException(SHORTEST_TRIP_FOR_THIS_CAR_IS, $data['car']->short_trip);
        }
        $delivery_fee = $this->getDeliveryFee($data);
        $bookInstant = $this->getTripType($data['car']);

        $tripBill = new TripBill();
        $avgPrice = $this->averagePrice($data['priceByDay']);
        $tripBill['trip_days'] = count($data['priceByDay']);
        $tripBill['deposit'] = $data['car']->deposit;
        $tripBill['average_price'] = $avgPrice;
        $tripBill['delivery_fee'] = $delivery_fee;
        $tripBill['trip_price'] = $this->calculateTripPrice($data['priceByDay']);
        $tripBill['booked_instantly'] = (boolean)$bookInstant;

        if(isset($data['oldTripBill']) && $data['oldTripBill']->promo_discount){
            $tripBill['promo_code'] = null;
            $tripBill['promo_code_discount'] = null;
            $tripBill['promo_discount'] = null;
            $tripBill['is_promo_fixed'] = null;
            $tripBill['discount_amount'] = null;
            $tripBill['price_with_discount'] = $tripBill['trip_price'] - $data['oldTripBill']->promo_discount;
        }else{
            $this->getDiscount($data, $tripBill);
        }

        $this->tripTotalEarning($tripBill);
        if($tripBill->is_promo_fixed){
            # promo code can be maximum 50% of full price
            $this->checkFixPromoCode($tripBill);
        }
        return $tripBill;
    }

    /**
     * @param $request
     * @return array
     */
    public function tripDates($request)
    {
        $startDate = Carbon::parse($request['price_from_date']);
        $startDateAddOne = Carbon::parse($request['price_from_date'])->addDay(1);
        $endDate = Carbon::parse($request['price_until_date']);
        //Calculate number of trip days
        $minutes = $endDate->diffInMinutes($startDate, true);
        $modulo = $minutes % 1440;
        $tripDates = [];
        if($modulo > 120){
            while ($startDate->lte($endDate)){
                array_push($tripDates, $startDate->format('Y-m-d'));
                $startDate->addDay(1);
            }
        }else{
            while ($startDateAddOne->lte($endDate)){
                array_push($tripDates, $startDateAddOne->format('Y-m-d'));
                $startDateAddOne->addDay(1);
            }
        }

        return $tripDates;
    }

    /**
     * @param $car
     * @return array
     */
    public function relatedIntervals($car)
    {
        $dates = $this->dates();
        // all price intervals for car
        $existingPrices = CustomPrice::where('car_id', $car->id)->orderBy('price_from_date', 'desc')->get();

        // all price intervals related with new custom price
        $listOfItems = [];
        foreach ($existingPrices as $existingPrice){
            switch($existingPrice){
                case(Carbon::parse($dates['newStartDate'])->gt(Carbon::parse($existingPrice->price_until_date)) && $existingPrice->price_until_date !== null):
                    break;
                case(Carbon::parse($dates['newEndDate'])->lt(Carbon::parse($existingPrice->price_from_date)) && $existingPrice->price_until_date !== null):
                    break;
                default:
                    array_push($listOfItems, $existingPrice);
                    break;
            }
        }

        return $listOfItems;
    }

    /**
     * @param $request
     * @param $relatedIntervals
     * @return array
     */
    public function pricePerDay($request, $relatedIntervals)
    {
        $tripDates = $this->tripDates($request);

        $startDate = Carbon::parse($request['price_from_date']);
        $endDate = Carbon::parse($request['price_until_date']);

        $startDateWithoutTime = $startDate->format('Y-m-d');
        $endDateWithoutTime = $endDate->format('Y-m-d');

        if($startDateWithoutTime === $endDateWithoutTime){
            $tripDates = [$startDateWithoutTime];
        }

        $priceByDay = [];

        $intervalDays = [];
        foreach ($relatedIntervals as $interval) {
            $dateFromInterval = $interval['price_from_date'];
            $dateUntilInterval = $interval['price_until_date'] !== null ? $interval['price_until_date'] : end($tripDates);
            switch($interval){
                /*case(Carbon::parse($interval['price_from_date'])->gt($endDate)):
                    break;
                case(Carbon::parse($dateUntilInterval)->lt($startDate)):
                    break;*/
                case(Carbon::parse($interval['price_from_date'])->lte($startDate) && Carbon::parse($interval['price_until_date'])->lte($endDate)):
                    for (Carbon::parse($dateFromInterval); Carbon::parse($dateFromInterval)->lte(Carbon::parse($dateUntilInterval)); $dateFromInterval = Carbon::parse($dateFromInterval)->addDay(1)->format('Y-m-d')) {
                        $intervalDays[$dateFromInterval] = $interval['price'] ? $interval['price'] : $interval['custom_price'];
                    }
                    break;
                case(Carbon::parse($interval['price_from_date'])->lte($startDate) && Carbon::parse($interval['price_until_date'])->gte($endDate)):
                    for (Carbon::parse($dateFromInterval); Carbon::parse($dateFromInterval)->lte(Carbon::parse($dateUntilInterval)); $dateFromInterval = Carbon::parse($dateFromInterval)->addDay(1)->format('Y-m-d')) {
                        $intervalDays[$dateFromInterval] = $interval['price'] ? $interval['price'] : $interval['custom_price'];
                    }
                    break;
                case(Carbon::parse($interval['price_from_date'])->gte($startDate) && Carbon::parse($interval['price_until_date'])->lte($endDate)):
                    for (Carbon::parse($dateFromInterval); Carbon::parse($dateFromInterval)->lte(Carbon::parse($dateUntilInterval)); $dateFromInterval = Carbon::parse($dateFromInterval)->addDay(1)->format('Y-m-d')) {
                        $intervalDays[$dateFromInterval] = $interval['price'] ? $interval['price'] : $interval['custom_price'];
                    }
                    break;
                case(Carbon::parse($interval['price_from_date'])->gte($startDate) && Carbon::parse($interval['price_until_date'])->gte($endDate)):
                    for (Carbon::parse($dateFromInterval); Carbon::parse($dateFromInterval)->lte(Carbon::parse($dateUntilInterval)); $dateFromInterval = Carbon::parse($dateFromInterval)->addDay(1)->format('Y-m-d')) {
                        $intervalDays[$dateFromInterval] = $interval['price'] ? $interval['price'] : $interval['custom_price'];
                    }
                    break;
                case(Carbon::parse($interval['price_from_date'])->lte($startDate) && $interval['price_until_date'] !== null):
                    for (Carbon::parse($dateFromInterval); Carbon::parse($dateFromInterval)->lte(Carbon::parse($dateUntilInterval)); $dateFromInterval = Carbon::parse($dateFromInterval)->addDay(1)->format('Y-m-d')) {
                        $intervalDays[$dateFromInterval] = $interval['price'] ? $interval['price'] : $interval['custom_price'];
                    }
                    break;
                case(Carbon::parse($interval['price_from_date'])->lte($startDate) && $interval['price_until_date'] === null):
                    for (Carbon::parse($dateFromInterval); Carbon::parse($dateFromInterval)->lte(Carbon::parse($dateUntilInterval)); $dateFromInterval = Carbon::parse($dateFromInterval)->addDay(1)->format('Y-m-d')) {
                        $intervalDays[$dateFromInterval] = $interval['price'] ? $interval['price'] : $interval['custom_price'];
                    }
                    break;
            }
        }

        foreach($tripDates as $tripDate){
            if(array_key_exists($tripDate, $intervalDays)){
                $priceByDay[$tripDate] = $intervalDays[$tripDate];
            }
        }
        return $priceByDay;
    }

    /**
     * @param $airport_id
     * @return mixed
     * @throws CustomException
     */
    private function checkAirport($airport_id)
    {
        $airport = CarAirport::findOrFail($airport_id);
        if($airport['work_on_airport']){
            $delivery_fee = $airport['delivery_fee'];
        }else{
            throw new CustomException(CAR_OWNER_DOES_NOT_GO_TO_THIS_AIRPORT);
        }
        return $delivery_fee;
    }

    /**
     * @param $car
     * @param $number_of_days
     * @param $data
     * @return null
     * @throws CustomException
     */
    private function checkGuestLocation($car, $number_of_days, $data)
    {
        $bookInstantly = BookInstantly::whereCarId($car->id)->firstOrFail();
        if($bookInstantly['max_distance'] !== null){
            $from['long_location'] = $car->long_location;
            $from['lat_location'] = $car->lat_location;
            $to['longitude'] = $data['long_location'];
            $to['latitude'] = $data['lat_location'];
            $distance = $this->locationDistances($from, $to);
            if($distance > $bookInstantly['max_distance']){
                throw new CustomException(CAR_OWNER_DOES_NOT_GO_TO_THIS_ADDRESS);
            }
        }

        if($bookInstantly['min_trip_for_free_delivery'] !== null){
            if($number_of_days > $bookInstantly['min_trip_for_free_delivery']){
                $bookInstantly['delivery_fee_guest_location'] = null;
            }
        }
        return $bookInstantly['delivery_fee_guest_location'];
    }

    /**
     * @param $priceByDay
     * @return float
     */
    public function averagePrice($priceByDay)
    {
        $sumOfPrices = 0;
        foreach($priceByDay as $k => $v){
            $sumOfPrices += $v;
        }
        return round($sumOfPrices / count($priceByDay));
    }

    /**
     * @param $priceByDay
     * @return int
     */
    public function calculateTripPrice($priceByDay)
    {
        $sumOfPrices = 0;
        foreach($priceByDay as $k => $v){
            $sumOfPrices += $v;
        }

        return $sumOfPrices;
    }

    /**
     * @param $data
     * @return array
     */
    public function getPricesPerDay($data)
    {
        $prices = [];
        $tripInterval = $this->createIntervalArray($data);
        foreach($tripInterval as $tripDate){
            $newDate = Carbon::createFromTimestamp($tripDate)->format('Y-m-d');
            $price = CustomPrice::whereCarId($data['car']->id)->where(function($q) use ($newDate){
                $q->whereRaw('? between price_from_date and IFNULL(price_until_date, "2200-01-01")', [$newDate]);
            })->first();
            $dateTime = Carbon::createFromTimestamp($tripDate)->toDateTimeString();
            $prices[$dateTime] = isset($price->price) ? (int)$price->price : (int)$price->custom_price;
        }
        return $prices;
    }
}
