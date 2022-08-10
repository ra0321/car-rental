<?php

namespace App\Traits\Earnings;

use App\Car;

trait OwnerEarningTrait {

	public function ownerEarnMapData($trips)
	{
		$response = [];
		$response['trips'] = [];
		$response['ownerEarnings'] = 0;
		foreach($trips as $k => $trip){
			$car = Car::findOrFail($trip->car_id);

			$values[$k]['ownerEarnFromTrip'] = 0;
			$values[$k]['ownerEarnFromTrip'] += (int)$trip->tripBill[0]->owner_earning;
			$values[$k]['ownerEarnFromTrip'] += isset($trip->tripBill[1]) ? (int)$trip->tripBill[1]->owner_earning : 0;
			if($values[$k]['ownerEarnFromTrip'] === 0){
				continue;
			}

			$values[$k]['id'] = (int)$trip->id;
			$values[$k]['chatId'] = (int)$trip->chat_id;
			$values[$k]['startDate'] = (string)$trip->start_date;
			$values[$k]['endDate'] = (string)$trip->end_date;
			$values[$k]['carManufacturer'] = (string)$car->car_manufacturer;
			$values[$k]['carManufacturerArabic'] = (string)$car->car_manufacturer_arabic;
			$values[$k]['carModel'] = (string)$car->car_model;
			$values[$k]['carYearOfProduction'] = (string)$car->production_year;
			$values[$k]['esarPaid'] = (boolean)$trip->tripBill[0]->esar_paid;
			$values[$k]['esarPaidDate'] = (string)$trip->tripBill[0]->esar_paid_date;
            if(!$trip->tripBill[0]->esar_paid){
                $response['ownerEarnings'] += (int)$trip->tripBill[0]->owner_earning;
                $response['ownerEarnings'] += isset($trip->tripBill[1]) ? (int)$trip->tripBill[1]->owner_earning : 0;
            }
			array_push($response['trips'], $values[$k]);
		}
		return $response;
	}
}
