<?php

namespace App\Traits\SuccessMethod;

use App\Exceptions\CustomException;
use App\TripBillHistory;
use App\TripHistory;
use Carbon\Carbon;
use DB;

/**
 * Trait SuccessTipMethodTrait
 * @package App\Traits\SuccessMethod
 */
trait SuccessTipMethodTrait {

	/**
	 * @param $method
	 * @param $trip
	 * @param $tripBill
	 */
	public function endOfTryBlock($method, $trip, $tripBill)
	{
		$method['endOfTryBlock']['time'] = Carbon::now();
		$method['tripData']['tripId'] = $trip->id;
		$method['tripData']['ownerId'] = $trip->owner_id;
		$method['tripData']['renterId'] = $trip->renter_id;
		$method['tripData']['chatId'] = $trip->chat_id;
		$method['tripData']['deliveryOnAirport'] = $trip->delivery_on_airport;
		$method['tripData']['deliveryOnCarLocation'] = $trip->delivery_on_car_location;
		$method['tripData']['deliveryOnRenterLocation'] = $trip->delivery_on_renter_location;
		$method['tripData']['airportId'] = $trip->airport_id;
		$method['tripData']['long_location'] = $trip->long_location;
		$method['tripData']['lat_location'] = $trip->lat_location;
		$method['tripData']['booked_instantly'] = $trip->booked_instantly;
		$method['tripData']['notice_time'] = $trip->notice_time;
		$method['tripData']['pickup_location'] = $trip->pickup_location;
		$method['tripData']['owner_confirm_trip'] = $trip->owner_confirm_trip;
		$method['tripData']['renterConfirmTrip'] = $trip->renter_confirm_trip;
		$method['tripData']['status'] = $trip->status;
		$method['tripData']['iAgree'] = $trip->i_agree;
		$method['tripData']['startDate'] = $trip->start_date;
		$method['tripData']['endDate'] = $trip->end_date;

		$method['tripBillData']['tripBillId'] = $tripBill->id;
		$method['tripBillData']['order_ref'] = $tripBill->order_ref;

		$jsonMethod = json_encode($method, JSON_PRETTY_PRINT);
		$fileName = storage_path() . '/' . 'MethodLogs/' . Carbon::now()->format('d-m-Y') . '/allLogs_' . Carbon::now()->format('H-i-s') . '-' . $trip->id . '.json';
		file_put_contents($fileName, $jsonMethod);
	}

	/**
	 * @param $trip
	 *
	 * @throws CustomException
	 */
	public function tripHistory($trip)
	{
		$history = new TripHistory();
		$tripArray = $trip->toArray();

		try{
			DB::beginTransaction();
			foreach($tripArray as $key => $value){
				$history[$key] = $value;
			}
			$history->save();
			DB::commit();
		}catch(\Exception $exception){
			DB::rollBack();
			throw new CustomException(SOMETHING_WENT_WRONG_WITH_SAVING_TRIP_HISTORY);
		}
	}

	/**
	 * @param $tripBill
	 *
	 * @throws CustomException
	 */
	public function tripBillHistory($tripBill)
	{
		$history = new TripBillHistory();
		$tripBillArray = $tripBill->toArray();

		try{
			DB::beginTransaction();
			foreach($tripBillArray as $key => $value){
				$history[$key] = $value;
			}
			$history->save();
			DB::commit();
		}catch(\Exception $exception){
			DB::rollBack();
			throw new CustomException(SOMETHING_WENT_WRONG_WITH_SAVING_TRIP_BILL_HISTORY);
		}
	}
}