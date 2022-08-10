<?php

namespace App\Http\Requests\Trip;

use App\Exceptions\CustomException;
use App\Models\Traits\Mutators;
use App\Rules\RealBool;
use App\Traits\CalculatorTrip;
use App\TripBill;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateTripRules
 * @package App\Http\Requests\Trip
 */
class UpdateTripRules extends FormRequest
{
    use CalculatorTrip, Mutators;

    /**
     * @return bool
     * @throws CustomException
     */
    public function authorize()
    {
        $trip = $this->route()->parameter('trip');
        $tripBill = TripBill::where('trip_id', $trip->id)->get()->all();
        $lastBill = end($tripBill);
        if(count($tripBill) > 1){
            throw new CustomException(YOU_CAN_NOT_CHANGED_TRIP_MORE_THEN_ONCE);
        }
        if($trip->owner_confirm_trip !== 'confirmed'){
            throw new CustomException(YOU_CAN_NOT_MODIFY_TRIP_UNTIL_CAR_OWNER_CONFIRM_TRIP);
        }
        if($lastBill->trip_bill_status == 'on hold'){
            throw new CustomException(THIS_TRANSACTION_IS_ON_HOLD_PLEASE_WAIT);
        }
        return true;
    }

    /**
     * @return array
     * @throws CustomException
     */
    public function rules()
    {
        $request = $this->request->all();
        $trip = $this->route()->parameter('trip');
        $tripBill = TripBill::where('trip_id', $trip->id)->first();
        $this->compareTwoTrips($trip, $request);
        /*$requestStartDate = Carbon::parse($request['price_from_date'])->format('Y-m-d H:i');
        $requestEndDate = Carbon::parse($request['price_until_date'])->format('Y-m-d H:i');
        $tripStartDate = Carbon::parse($tripBill->trip_start_date)->format('Y-m-d H:i');
	    $tripEndDate = Carbon::parse($tripBill->trip_end_date)->format('Y-m-d H:i');
        if($requestStartDate === $tripStartDate && $requestEndDate === $tripEndDate){
	        throw new CustomException(YOUR_TRIP_HAS_NOT_CHANGED);
        }
        if(count($request) === 1 && isset($request['message'])){
            throw new CustomException(YOUR_TRIP_HAS_NOT_CHANGED);
        }*/
        if($trip->status === 'started'){
            $this->modificationAfterStart($trip, $request);
        }else{
	        if($trip->trip_modified){
		        if(isset($request['price_from_date']) && isset($request['price_until_date'])){
			        $tripDates = $this->tripDates($request);
			        if(count($tripDates) < $tripBill->trip_days){
				        throw new CustomException(YOU_MAY_ONLY_TO_EXTEND_THE_TRIP);
			        }
		        }
	        }
        }

        if(isset($request['pick_on_airport']) && isset($request['pick_on_car_location']) && isset($request['pick_on_guest_location'])){
            $pick_on_airport = $this->changeToBool($request['pick_on_airport']);
            $pick_on_car_location = $this->changeToBool($request['pick_on_car_location']);
            $pick_on_guest_location = $this->changeToBool($request['pick_on_guest_location']);
            switch($request){
                case($pick_on_airport === true):
                    if($pick_on_airport === $pick_on_car_location || $pick_on_airport === $pick_on_guest_location){
                        throw new CustomException(YOU_MUST_CHOOSE_ONLY_ONE_LOCATION);
                    }
                    break;
                case($pick_on_car_location === true):
                    if($pick_on_car_location === $pick_on_airport || $pick_on_car_location === $pick_on_guest_location){
                        throw new CustomException(YOU_MUST_CHOOSE_ONLY_ONE_LOCATION);
                    }
                    break;
                case($pick_on_guest_location === true):
                    if($pick_on_guest_location === $pick_on_airport || $pick_on_guest_location === $pick_on_car_location){
                        throw new CustomException(YOU_MUST_CHOOSE_ONLY_ONE_LOCATION);
                    }
                    break;
                default:
                    throw new CustomException(YOU_MUST_CHOOSE_AT_LEAST_ONE_LOCATION);
            }
        }
        if($trip->status === 'started'){
	        $now = Carbon::now()->addHours(12);
            return [
	            'price_until_date' => 'required|date|after:' . $now,
                'pick_on_airport' => ['required_with:pick_on_car_location,pick_on_guest_location', new RealBool(PICK_ON_AIRPORT)],
                'airport_id' => 'required_if:pick_on_airport,true|numeric',
                'pick_on_car_location' => ['required_with:pick_on_airport,pick_on_guest_location', new RealBool(PICK_ON_CAR_LOCATION)],
                'pick_on_guest_location' => ['required_with:pick_on_airport,pick_on_guest_location', new RealBool(PICK_ON_GUEST_LOCATION)],
                'long_location' => 'required_if:pick_on_guest_location,true|numeric',
                'lat_location' => 'required_if:pick_on_guest_location,true|numeric'
            ];
        }else{
            return [
                'price_from_date' => 'required_with:price_until_date|date',
                'price_until_date' => 'required_with:price_from_date|date|after:price_from_date',
                'pick_on_airport' => ['required_with:pick_on_car_location,pick_on_guest_location', new RealBool(PICK_ON_AIRPORT)],
                'airport_id' => 'required_if:pick_on_airport,true|numeric',
                'pick_on_car_location' => ['required_with:pick_on_airport,pick_on_guest_location', new RealBool(PICK_ON_CAR_LOCATION)],
                'pick_on_guest_location' => ['required_with:pick_on_airport,pick_on_guest_location', new RealBool(PICK_ON_GUEST_LOCATION)],
                'long_location' => 'required_if:pick_on_guest_location,true|numeric',
                'lat_location' => 'required_if:pick_on_guest_location,true|numeric'
            ];
        }
    }

    /**
     * @param $trip
     * @param $request
     * @throws CustomException
     */
    private function modificationAfterStart($trip, $request)
    {
	    if(isset($request['price_from_date'])){
		    $newStartDate = Carbon::parse($request['price_from_date'])->format('Y-m-d H:i:s');
		    $oldStartDate = Carbon::parse($trip->start_date)->format('Y-m-d H:i:s');
		    if($newStartDate != $oldStartDate){
			    throw new CustomException(YOU_CAN_NOT_CHANGE_STARTING_DATE_FOR_STARTED_TRIP);
		    }
	    }
    }

    /**
     * @param $trip
     * @param $request
     * @throws CustomException
     */
    private function compareTwoTrips($trip, $request)
    {
        $tripStartDate = Carbon::parse($trip->start_date)->getTimestamp();
        $tripEndDate = Carbon::parse($trip->end_date)->getTimestamp();
        $oldTrip = [];
        $oldTrip['price_from_date'] = $tripStartDate;
        $oldTrip['price_until_date'] = $tripEndDate;
        $oldTrip['pick_on_airport'] = (boolean)$trip->delivery_on_airport;
        $oldTrip['airport_id'] = $trip->airport_id;
        $oldTrip['pick_on_car_location'] = (boolean)$trip->delivery_on_car_location;
        $oldTrip['long_location'] = $trip->long_location;
        $oldTrip['lat_location'] = $trip->lat_location;
        $oldTrip['pick_on_guest_location'] = (boolean)$trip->delivery_on_renter_location;
        $newValues = [];
        $newValues['price_from_date'] = isset($request['price_from_date']) ? Carbon::parse($request['price_from_date'])->getTimestamp() : $tripStartDate;
        $newValues['price_until_date'] = isset($request['price_until_date']) ? Carbon::parse($request['price_until_date'])->getTimestamp() : $tripEndDate;
        $newValues['pick_on_airport'] = isset($request['pick_on_airport']) ? (boolean)$request['pick_on_airport'] : (boolean)$trip->delivery_on_airport;
        $newValues['airport_id'] = isset($request['airport_id']) ? $request['airport_id'] : $trip->airport_id;
        $newValues['pick_on_car_location'] = isset($request['pick_on_car_location']) ? (boolean)$request['pick_on_car_location'] : (boolean)$trip->delivery_on_car_location;
        $newValues['long_location'] = isset($request['long_location']) ? $request['long_location'] : $trip->long_location;
        $newValues['lat_location'] = isset($request['lat_location']) ? $request['lat_location'] : $trip->lat_location;
        $newValues['pick_on_guest_location'] = isset($request['pick_on_guest_location']) ? (boolean)$request['pick_on_guest_location'] : (boolean)$trip->delivery_on_renter_location;
        $result = array_diff_assoc($oldTrip, $newValues);
        if(empty($result)){
            throw new CustomException(YOUR_TRIP_HAS_NOT_CHANGED);
        }
    }

    /**
     * @return array
     */
    public function messages()
    {
	    $trip = $this->route()->parameter('trip');
	    if($trip->status === 'started'){
		    $now = Carbon::now()->addHours(12);
		    $message = ['message' => ['lang' => ['en' => THE_PRICE_FROM_DATE_MUST_BE_A_DATE_AFTER['message']['lang']['en'] . $now, 'ar' => THE_PRICE_FROM_DATE_MUST_BE_A_DATE_AFTER['message']['lang']['ar'] . $now]]];
	    }else{
		    $message = ['message' => ['lang' => ['en' => THE_PRICE_FROM_DATE_MUST_BE_A_DATE_AFTER['message']['lang']['en'] . $trip->start_date, 'ar' => THE_PRICE_FROM_DATE_MUST_BE_A_DATE_AFTER['message']['lang']['ar'] . $trip->start_date]]];
	    }
	    return [
		    'price_until_date.after' => $message,
	    ];
    }
}
