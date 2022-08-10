<?php

namespace App\Traits\Trip;

/**
 * Trait TripCancelTrait
 * @package App\Traits\Trip
 */
trait TripCancelTrait {

	/**
	 * @param $tripBill
	 * @param $jsonParams
	 *
	 * @return mixed
	 */
	public function cancelTripBill($tripBill, $jsonParams)
	{
		if($jsonParams['tran']['type'] === 'void'){
			$tripBill['trip_total'] = $tripBill['trip_total'] + $jsonParams['tran']['amount'];
		}else{
			$tripBill['trip_total'] = $tripBill['trip_total'] - $jsonParams['tran']['amount'];
		}
		$tripBill['owner_earning'] = floor(($tripBill['trip_total'] * 85) / 100);
		$tripBill['esar_earning'] = $tripBill['trip_total'] - $tripBill['owner_earning'];
		$tripBill['trip_bill_status'] = 'canceled';
		$tripBill['trip_paid'] = false;
		return $tripBill;
	}

	/**
	 * @param $tripBills
	 */
	public function correctionOfInitialTransaction($tripBills)
	{
		$tripBills[1]['trip_total'] = $tripBills[0]['trip_total'] + $tripBills[1]['trip_total'];
		$tripBills[1]['owner_earning'] = $tripBills[0]['owner_earning'] + $tripBills[1]['owner_earning'];
		$tripBills[1]['esar_earning'] = $tripBills[0]['esar_earning'] + $tripBills[1]['esar_earning'];
		$tripBills[1]->save();
	}
}
