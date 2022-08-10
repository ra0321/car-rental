<?php

namespace App\Traits;

use App\CarAvailable;
use App\Exceptions\CustomException;
use App\Traits\Payment\ClientResponse;
use App\Traits\Payment\PaymentParams;
use App\Traits\Trip\TripCancelTrait;
use App\Trip;
use App\TripBill;
use App\User;
use App\UserAvailable;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Log;

/**
 * Trait RenterTripCancel
 * @package App\Traits
 */
trait RenterTripCancel
{
    use ApiResponser, PaymentParams, ClientResponse, TripCancelTrait;

	/**
	 * @param Trip $trip
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	/*public function renterCancelTrip(Trip $trip)
    {
	    $tripBills = TripBill::where('trip_id', $trip->id)->orderBy('id', 'desc')->get();
	    $user = User::where('id', $trip->renter_id)->first();
	    $userAvailable = UserAvailable::where('user_id', $user->id)->where('trip_id', $trip->id)->first();
	    $carAvailable = CarAvailable::where('car_id', $trip->car_id)->where('trip_id', $trip->id)->first();
	    $now = Carbon::now();
	    $hours_to_trip = Carbon::parse($trip['start_date'])->diffInHours($now);
	    $withinHour = $this->withinHour($trip);

	    ###############
	    # FOR TESTING #
	    ###############
	    //switch (true){
        //   case $hours_to_trip < 24 :
		//	    $message = $this->lessThanDay($tripBills);
		//	    break;
		//    case $hours_to_trip > 168 :
		//	    $message = $this->moreThanSevenDays($tripBills);
		//	    break;
		//    default:
		//	    $message = $this->lessThanSevenDays($tripBills);
	    //}

        ########
        # LIVE #
        ########
	    if($withinHour){
			$message = $this->cancelTripWithinOneHour($tripBills);
	    }else{
		    switch (true){
			    case $hours_to_trip < 24 :
				    $message = $this->lessThanDay($tripBills);
				    break;
			    case $hours_to_trip > 168 :
				    $message = $this->moreThanSevenDays($tripBills);
				    break;
			    default:
				    $message = $this->lessThanSevenDays($tripBills);
		    }
	    }

	    try{
		    $user['count_penalty_renter'] += 1;
		    $trip['renter_confirm_trip'] = 'canceled';
		    $trip['status'] = 'canceled';
		    if($trip['owner_confirm_trip_update'] === 'waiting'){
			    $trip['owner_confirm_trip_update'] = 'auto_rejected';
			    $trip['renter_confirm_trip_update'] = false;
		    }
		    $trip->save();
		    $user->save();
		    $userAvailable->delete();
		    $carAvailable->delete();
	    }catch (QueryException $exception){
	    	Log::emergency($exception->getMessage());
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }

	    return $message;
    }*/

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function cancelTripWithinOneHour($tripBills)
    {
	    try{
		    foreach($tripBills as $tripBill){
			    switch($tripBill){
					case($tripBill['trip_bill_status'] === 'accepted' && $tripBill['trip_total'] > 0):
					    $params = $this->refundWholeAmount($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
					case($tripBill['trip_bill_status'] === 'pre_auth' && $tripBill['trip_total'] > 0):
					    $params = $this->releaseWholeAmount($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
					default:
					    $tripBill['trip_bill_status'] = 'canceled';
					    $tripBill['trip_paid'] = false;
					    $tripBill['trip_total'] = 0;
					    $tripBill['owner_earning'] = 0;
					    $tripBill['esar_earning'] = 0;
					    $tripBill->save();
					    continue 2;
					    break;
			    }
			    $jsonParams = $this->jsonParams($params);
			    $tripBill = $this->cancelTripBill($tripBill, $jsonParams);

			    if(isset($jsonResponse['auth']['tranref'])){
				    $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
			    }
			    $tripBill->save();
		    }
	    }catch (CustomException $exception){
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }
	    return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function moreThanSevenDays($tripBills)
    {
	    try{
		    foreach($tripBills as $tripBill){
			    switch($tripBill){
					case($tripBill['trip_bill_status'] === 'accepted' && $tripBill['trip_total'] > 0):
					    $params = $this->refundWithFirstPenalty($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
					case($tripBill['trip_bill_status'] === 'pre_auth' && $tripBill['trip_total'] > 0):
					    $params = $this->releaseWholeAmount($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
					default:
					    $tripBill['trip_bill_status'] = 'canceled';
					    $tripBill['trip_paid'] = false;
					    $tripBill['trip_total'] = 0;
					    $tripBill['owner_earning'] = 0;
					    $tripBill['esar_earning'] = 0;
					    $tripBill->save();
					    continue 2;
					    break;
			    }
			    $jsonParams = $this->jsonParams($params);
			    $tripBill = $this->cancelTripBill($tripBill, $jsonParams);

			    if(isset($jsonResponse['auth']['tranref'])){
				    $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
			    }
			    $tripBill->save();
		    }
	    }catch (CustomException $exception){
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }
	    return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function lessThanSevenDays($tripBills)
    {
	    try{
		    foreach($tripBills as $tripBill){
			    switch($tripBill){
				    case($tripBill['trip_bill_status'] === 'accepted' && $tripBill['trip_total'] > 0):
					    $params = $this->refundWithSecondPenalty($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
				    case($tripBill['trip_bill_status'] === 'pre_auth' && $tripBill['trip_total'] > 0):
					    $params = $this->releaseWholeAmount($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
				    default:
					    $tripBill['trip_bill_status'] = 'canceled';
					    $tripBill['trip_paid'] = false;
					    $tripBill['trip_total'] = 0;
					    $tripBill['owner_earning'] = 0;
					    $tripBill['esar_earning'] = 0;
					    $tripBill->save();
					    continue 2;
					    break;
			    }
			    $jsonParams = $this->jsonParams($params);
			    $tripBill = $this->cancelTripBill($tripBill, $jsonParams);

			    if(isset($jsonResponse['auth']['tranref'])){
				    $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
			    }
			    $tripBill->save();
		    }
	    }catch (CustomException $exception){
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }
	    return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	/*public function lessThanDay($tripBills)
    {
    	switch ($tripBills){
		    case(count($tripBills->all()) > 1):
			    if($tripBills[0]->trip_bill_status !== 'accepted'){
				    $tripIsLong = $tripBills[1]->trip_days;
			    }else{
				    $tripIsLong = $tripBills[0]->trip_days;
			    }
			    if($tripIsLong === 1){
				    $message = $this->fullChargeWithModification($tripBills);
			    }else{
				    $message = $this->chargeWithPenaltyWithModification($tripBills);
			    }
			    break;
		    default:
			    $tripIsLong = $tripBills[0]->trip_days;
			    if($tripIsLong === 1){
				    $message = $this->fullCharge($tripBills);
			    }else{
				    $message = $this->chargeWithPenalty($tripBills);
			    }
			    break;
	    }
	    return $message;
    }*/

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	/*public function chargeWithPenaltyWithModification($tripBills)
    {
    	$minForRefund = ($tripBills[0]['trip_total'] * 0.15) + ($tripBills[0]['average_price'] / 2);
	    if($tripBills[0]['trip_bill_status'] === 'accepted' && $minForRefund < $tripBills[0]['trip_total']){
		    $this->refundFromBothBills($tripBills);
	    }else{
		    $this->refundFromInitialBill($tripBills);
	    }
	    return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }*/

	/**
	 * @param $tripBills
	 *
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function refundFromInitialBill($tripBills)
    {
	    try{
		    foreach($tripBills as $i => $tripBill){
			    switch($tripBill){
					case($tripBill['trip_bill_status'] === 'accepted' && $tripBill['trip_total'] > 0):
						if($i == 0){
							$params = $this->refundWithSecondPenalty($tripBill);
							$clientResponse = $this->remoteXml($params);
							$jsonResponse = $this->paymentParse($clientResponse);
						}else{
							$params = $this->refundLessOneDay($tripBill);
							$clientResponse = $this->remoteXml($params);
							$jsonResponse = $this->paymentParse($clientResponse);
						}
					    break;
					case($tripBill['trip_bill_status'] === 'pre_auth' && $tripBill['trip_total'] > 0):
					    $params = $this->releaseWholeAmount($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
				    default:
					    $tripBill['trip_bill_status'] = 'canceled';
					    $tripBill['trip_paid'] = false;
					    $tripBill['trip_total'] = 0;
					    $tripBill['owner_earning'] = 0;
					    $tripBill['esar_earning'] = 0;
					    $tripBill->save();
					    continue 2;
					    break;
			    }
			    $jsonParams = $this->jsonParams($params);
			    $tripBill = $this->cancelTripBill($tripBill, $jsonParams);

			    if(isset($jsonResponse['auth']['tranref'])){
				    $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
			    }
			    $tripBill->save();
		    }
	    }catch (CustomException $exception){
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }
    }

	/**
	 * @param $tripBills
	 *
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	/*public function refundFromBothBills($tripBills)
    {
	    try{
		    foreach($tripBills as $tripBill){
			    $params = $this->refundLessOneDay2ndVersion($tripBill);
			    $clientResponse = $this->remoteXml($params);
			    $jsonResponse = $this->paymentParse($clientResponse);

			    $jsonParams = $this->jsonParams($params);
			    $tripBill = $this->cancelTripBill($tripBill, $jsonParams);

			    if(isset($jsonResponse['auth']['tranref'])){
				    $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
			    }
			    $tripBill->save();
		    }
	    }catch (CustomException $exception){
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }
    }*/

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function fullChargeWithModification($tripBills)
    {
	    try{
		    foreach($tripBills as $tripBill){
			    switch($tripBill){
					case($tripBill['trip_bill_status'] === 'accepted' && $tripBill['trip_total'] > 0):
					    $tripBill['trip_bill_status'] = 'canceled';
					    $tripBill['trip_paid'] = false;
					    $tripBill->save();
					    continue 2;
					    break;
					case($tripBill['trip_bill_status'] === 'pre_auth' && $tripBill['trip_total'] > 0):
					    $params = $this->releaseWholeAmount($tripBill);
					    $clientResponse = $this->remoteXml($params);
					    $jsonResponse = $this->paymentParse($clientResponse);
					    break;
				    default:
					    $tripBill['trip_bill_status'] = 'canceled';
					    $tripBill['trip_paid'] = false;
					    $tripBill['trip_total'] = 0;
					    $tripBill['owner_earning'] = 0;
					    $tripBill['esar_earning'] = 0;
					    $tripBill->save();
					    continue 2;
					    break;
			    }
			    $jsonParams = $this->jsonParams($params);
			    $tripBill = $this->cancelTripBill($tripBill, $jsonParams);

			    if(isset($jsonResponse['auth']['tranref'])){
				    $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
			    }
			    $tripBill->save();
		    }
	    }catch (CustomException $exception){
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }
	    return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	/*public function chargeWithPenalty($tripBills)
	{
		try{
			switch ($tripBills){
				case($tripBills[0]['trip_bill_status'] === 'accepted'):
					$params = $this->refundLessOneDay($tripBills[0]);
					$clientResponse = $this->remoteXml($params);
					$jsonResponse = $this->paymentParse($clientResponse);
					break;
				default:
					$params = $this->releaseWholeAmount($tripBills[0]);
					$clientResponse = $this->remoteXml($params);
					$jsonResponse = $this->paymentParse($clientResponse);
					break;
			}
			$jsonParams = $this->jsonParams($params);
			$tripBills[0] = $this->cancelTripBill($tripBills[0], $jsonParams);
			if(isset($jsonResponse['auth']['tranref'])){
				$tripBills[0]['tran_ref'] = $jsonResponse['auth']['tranref'];
			}
			$tripBills[0]->save();
		}catch (CustomException $exception){
			throw new CustomException(SOMETHING_WENT_WRONG);
		}
		return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
	}*/

	/**
	 * @param $tripBills
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws CustomException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	/*public function fullCharge($tripBills)
    {
	    try{
	    	switch ($tripBills){
			    case($tripBills[0]['trip_bill_status'] === 'accepted'):
				    $tripBills[0]['trip_bill_status'] = 'canceled';
				    $tripBills[0]['trip_paid'] = false;
				    $tripBills[0]->save();
				    break;
			    default:
				    $params = $this->releaseWholeAmount($tripBills[0]);
				    $clientResponse = $this->remoteXml($params);
				    $jsonResponse = $this->paymentParse($clientResponse);

				    $jsonParams = $this->jsonParams($params);
				    $tripBills[0] = $this->cancelTripBill($tripBills[0], $jsonParams);
				    if(isset($jsonResponse['auth']['tranref'])){
					    $tripBills[0]['tran_ref'] = $jsonResponse['auth']['tranref'];
				    }
				    $tripBills[0]->save();
				    break;
		    }
	    }catch (CustomException $exception){
		    throw new CustomException(SOMETHING_WENT_WRONG);
	    }
	    return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }*/

    /**
     * @param Trip $trip
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelStartedTrip(Trip $trip)
    {
        $trip['status'] = 'unfinished';
        $trip['renter_confirm_trip'] = 'shortened';
        $trip->save();
        return $this->successResponseWithMessage(OWNER_WILL_RECEIVE_EMAIL_WITH_CANCELLATION_REQUEST);
    }

	/**
	 * @param Trip $trip
	 *
	 * @return bool
	 */
	public function withinHour(Trip $trip)
	{
		$bookedInstantly = $trip->booked_instantly;
		if($bookedInstantly){
			$minutes = $this->bookedInstantlyTime($trip);
		}else{
			$minutes = $this->requestedTripTime($trip);
		}
		if($minutes < 60){
			return true;
		}
		return false;
	}

	/**
	 * @param Trip $trip
	 *
	 * @return int
	 */
	public function bookedInstantlyTime(Trip $trip)
	{
		$now = Carbon::now();
		$tripCreated = Carbon::parse($trip->created_at);
		$minutes = $tripCreated->diffInMinutes($now);
		return $minutes;
	}

	/**
	 * @param Trip $trip
	 *
	 * @return int
	 */
	public function requestedTripTime(Trip $trip)
	{
		$now = Carbon::now();
		$tripCreated = Carbon::parse($trip->updated_at);
		$minutes = $tripCreated->diffInMinutes($now);
		return $minutes;
	}
}
