<?php

namespace App\Http\Filters;

use App\Helpers\Currency\CurrencyHelper;
use App\Traits\ValueTransform;
use App\User;
use Carbon\Carbon;
use DB;
use App\Car;

/**
 * Trait Helpers
 * @package App\Http\Filters
 */
trait Helpers
{
	use ValueTransform;
    /**
     * @param $request
     * @param $filters
     * @return mixed
     */
    public function carFilteredQuery($request, $filters)
    {
        $cars = Car::with('carRestriction', 'customPrice', 'bookInstantly', 'carFeature')
            ->where('car_city', $request['city'])
            ->where('car_is_active', true)
            ->filter($filters)
            ->orderBy('paid_advertising', 'desc')
            ->get();
        return $cars;
    }

    /**
     * @param $id
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function carFilteredQueryIATA($id, $filters)
    {
        $car = Car::with('carRestriction', 'customPrice', 'bookInstantly', 'carFeature')
            ->where('id', $id->car_id)
            ->where('car_is_active', true)
            ->filter($filters)
            ->first();
        return $car;
    }

    /**
     * @param $id
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function carFilteredQueryAirport($id, $filters)
    {
        $car = Car::with('carRestriction', 'customPrice', 'bookInstantly', 'carFeature')
            ->where('id', $id->car_id)
            ->where('car_is_active', true)
            ->filter($filters)
            ->first();
        return $car;
    }

    /**
     * @param $request
     * @return array
     */
    public function carIdsQuery($request)
    {
        $carIds = DB::table('car_airports')
            ->select('car_id')
            ->distinct()
            ->where('airport_city', $request['city'])
            ->get()->all();
        return $carIds;
    }
    /**
     * @param $allCars
     * @param $car
     * @return bool
     */
    public function checkIfExist($allCars, $car)
    {
        foreach ($allCars as $item){
            if($item['carId'] === $car->id){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $carIds
     * @param $filters
     * @return array
     */
    public function carFromAirport($carIds, $filters)
    {
        $carFromAirport = [];
        foreach ($carIds as $item){
            $carAirport = Car::whereId($item->car_id)->where('car_is_active', true)->filter($filters)->first();
            if($carAirport !== null){
                array_push($carFromAirport, $carAirport);
            }
        }
        return $carFromAirport;
    }

    /**
     * @param $allCars
     * @param $request
     * @return mixed
     */
    public function sortFilter($allCars, $request)
    {
        $price = array();
        foreach ($allCars as $key => $row)
        {
            $price[$key] = $row['priceForFirstDay'];
        }
        if(isset($request['sort']) && $request['sort'] === 'asc'){
            array_multisort($price, SORT_ASC, $allCars);
            return $allCars;
        }
        array_multisort($price, SORT_DESC, $allCars);
        return $allCars;
    }

    /**
     * @param $allCars
     * @param $request
     * @return mixed
     */
    public function minPriceFilter($allCars, $request)
    {
        foreach ($allCars as $key => $car){
            if($request['min_price'] > $car['priceForFirstDay']){
                unset($allCars[$key]);
            }
        }
        return $allCars;
    }

    /**
     * @param $allCars
     * @param $request
     * @return mixed
     */
    public function maxPriceFilter($allCars, $request)
    {
        foreach ($allCars as $key => $car){
            if($request['max_price'] < $car['priceForFirstDay']){
                unset($allCars[$key]);
            }
        }
        return $allCars;
    }

    /**
     * @param $request
     * @param $allCars
     * @return mixed
     */
    public function removeUnavailable($request, $allCars)
    {
        if(isset($request['start_date']) && isset($request['end_date'])){
            foreach($allCars as $key => $oneCar){
                $checkDate = $this->checkCarAvailability($request, $oneCar);
                if(!$checkDate){
                    unset($allCars[$key]);
                }
            }
        }
        return $allCars;
    }

    /**
     * @param $car
     * @param $request
     * @return mixed
     */
    public function mapValues($car, $request)
    {
        $air = $car->carAirport->all();
        foreach ($air as $item){
        	if($item['work_on_airport'] == true){
        		$carWorkOnAirport = true;
        		break;
	        }else{
		        $carWorkOnAirport = false;
	        }
        }
        $getPrice = $this->getPriceForDay($car, $request['start_date']);
        $result['carId'] = $car->id;
        $result['userId'] = $car->user_id;
        $result['priceForFirstDay'] = CurrencyHelper::exchange((int)$getPrice);
        $result['carManufacturer'] = $car->car_manufacturer;
        $result['carManufacturerArabic'] = $car->car_manufacturer_arabic;
        $result['carModel'] = $car->car_model;
        $result['yearOfProduction'] = $car->production_year;
        $result['city'] = $car->car_city;
        $result['longitude'] = $car->long_location;
        $result['latitude'] = $car->lat_location;
        $result['airportCity'] = empty($air) ? null : $car->carAirport[0]->airport_city;
        $result['airportCityArabic'] = empty($air) ? null : $car->carAirport[0]->arabic_airport_city;
        $result['deliveryFeeAirport'] = empty($air) ? null : $car->carAirport[0]->delivery_fee;
        $result['workOnAirport'] = empty($air) ? false : (boolean)$carWorkOnAirport;
        $result['countStars'] = $car->count_stars;
        $result['countTrips'] = $car->count_trips;
        $result['bookInstantlyOnCarLocation'] = isset($car->bookInstantly) ? (boolean)$car->bookInstantly->on_car_location : null;
        $result['bookInstantlyOnAirport'] = isset($car->bookInstantly) ? (boolean)$car->bookInstantly->on_airport : null;
        $result['bookInstantlyOnGuestLocation'] = isset($car->bookInstantly) ? (boolean)$car->bookInstantly->on_guest_location : null;
        $result['workOnGuestLocation'] = isset($car->bookInstantly) ? (boolean)$car->bookInstantly->work_on_guest_location : null;
        $result['deliveryFeeGuestLocation'] = isset($car->bookInstantly) ? $car->bookInstantly->delivery_fee_guest_location : null;
        $result['kmPerDay'] = isset($car->carRestriction) ? $car->carRestriction->km_per_day : null;
        $result['kmPerWeek'] = isset($car->carRestriction) ? $car->carRestriction->km_per_week : null;
        $result['kmPerMonth'] = isset($car->carRestriction) ? $car->carRestriction->km_per_month : null;
        $result['smallImagePath'] = $car->carImage[0]->small_image_path;


        // carFeatures
        $result['hybrid'] = $car->carFeature->hybrid;
        $result['bikeRack'] = $car->carFeature->bike_rack;
        $result['drive'] = $car->carFeature->all_drive;
        $result['childSeat'] = $car->carFeature->child_seat;
        $result['gps'] = $car->carFeature->gps;
        $result['skiRack'] = $car->carFeature->ski_rack;
        $result['bluetooth'] = $car->carFeature->bluetooth;
        $result['usb'] = $car->carFeature->usb;
        $result['ventilatedSeat'] = $car->carFeature->ventilated_seat;
        $result['audioInput'] = $car->carFeature->audio_input;
        $result['convertible'] = $car->carFeature->convertible;
        $result['sunroof'] = $car->carFeature->sunroof;
        $result['tollPass'] = $car->carFeature->toll_pass;
        $result['color'] = $car->carFeature->color;

        // Vehicle Types
        $result['vehicleType'] = $car->vehicle_type;
        $result['transmission'] = $car->car_transmission;
        $result['category'] = $car->model_class;

        return $result;
    }

	/**
	 * @param $request
	 * @param $car
	 *
	 * @return bool
	 */
	public function ownerWorkTime($request, $car)
    {
        $user = User::findOrFail($car->user_id);
        $ownerFrom = Carbon::parse($user->work_from_time);
        $ownerUntil = Carbon::parse($user->work_until_time);
        $renterFromTimeString = Carbon::parse($request['start_date'])->toTimeString();
        $renterUntilTimeString = Carbon::parse($request['end_date'])->toTimeString();
        $renterStartTime = Carbon::parse($renterFromTimeString);
        $renterEndTime = Carbon::parse($renterUntilTimeString);

        if($ownerFrom->lte($renterStartTime) && $ownerUntil->gte($renterEndTime)){
            return true;
        }
        return false;
    }

    /**
     * @param $car
     * @param $request
     * @return bool
     */
    public function shortLongTripRemove($car, $request)
    {
        $shortest_trip = $this->shortestTrip($car, $request);
        $longest_trip = $this->longestTrip($car, $request);
        $tripDays = $this->tripDays($request);
        if($tripDays >= $shortest_trip && $tripDays <= $longest_trip){
            return true;
        }
        return false;
    }

    /**
     * @param $car
     * @param $request
     * @return int
     */
    public function shortestTrip($car, $request)
    {
        $sample = Carbon::parse($request['start_date']);
        $start_date_carbon = Carbon::parse($request['start_date']);
        switch($car['short_trip']){
            case($car['short_trip'] === '1 day'):
                $days = 1;
                break;
            case($car['short_trip'] === '2 days'):
                $days = 2;
                break;
            case($car['short_trip'] === '3 days'):
                $days = 3;
                break;
            case($car['short_trip'] === '5 days'):
                $days = 5;
                break;
            case($car['short_trip'] === '1 week'):
                $days = 7;
                break;
            case($car['short_trip'] === '2 weeks'):
                $days = 14;
                break;
            case($car['short_trip'] === '1 month'):
                $end = $start_date_carbon->addMonths(1);
                $days = $end->diffInDays($sample);
                break;
            default:
                $days = 0;
        }
        return $days;
    }

    /**
     * @param $car
     * @param $request
     * @return int
     */
    public function longestTrip($car, $request)
    {
        $sample = Carbon::parse($request['start_date']);
        $start_date_carbon = Carbon::parse($request['start_date']);
        switch($car['long_trip']){
            case($car['long_trip'] === '3 days'):
                $days = 3;
                break;
            case($car['long_trip'] === '5 days'):
                $days = 5;
                break;
            case($car['long_trip'] === '1 week'):
                $days = 7;
                break;
            case($car['long_trip'] === '2 weeks'):
                $days = 14;
                break;
            case($car['long_trip'] === '1 month'):
                $end = $start_date_carbon->addMonths(1);
                $days = $end->diffInDays($sample);
                break;
            case($car['long_trip'] === '3 months'):
                $end = $start_date_carbon->addMonths(3);
                $days = $end->diffInDays($sample);
                break;
            default:
                $days = 10000000;
        }
        return $days;
    }

    /**
     * @param $request
     * @return int
     */
    public function tripDays($request)
    {
        $start_date = Carbon::parse($request['start_date']);
        $end_date = Carbon::parse($request['end_date']);
        $days = $end_date->diffInDays($start_date);
        return $days;
    }

	/**
	 * @param Car $car
	 * @param $request
	 *
	 * @return bool
	 */
	public function checkAdvanceNotice(Car $car, $request)
	{
		$notice = $this->noticeTransform($car->notice);
		$hours = Carbon::now()->diffInHours(Carbon::parse($request['start_date']));
		if($hours < $notice){
			return false;
		}
		return true;
	}

	/**
	 * @param $request
	 *
	 * @return bool
	 */
	public function searchLongWeekend($request)
	{
		$tripDays = $this->tripDays($request);
		$dayOfWeek = $this->dayOfWeek($request);
		if($tripDays < 2){
			if($dayOfWeek === 4 || $dayOfWeek === 5){
				return false;
			}
		}
		return true;
	}

	/**
	 * @param $request
	 *
	 * @return int
	 */
	public function dayOfWeek($request)
	{
		$dayOfWeek = Carbon::parse($request['start_date'])->format('N');
		return (int)$dayOfWeek;
	}
}
