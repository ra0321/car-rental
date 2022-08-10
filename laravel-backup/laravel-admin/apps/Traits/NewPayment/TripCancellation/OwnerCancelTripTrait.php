<?php


namespace App\Traits\NewPayment\TripCancellation;


use App\CarAvailable;
use App\Exceptions\CustomException;
use App\Trip;
use App\TripBill;
use App\User;
use App\UserAvailable;
use Carbon\Carbon;
use Exception;

trait OwnerCancelTripTrait
{
    /**
     * @param Trip $trip
     * @return mixed
     * @throws CustomException
     */
    public function ownerCancelTrip(Trip $trip)
    {
        $now = Carbon::now();
        $tripBills = TripBill::where('trip_id', $trip->id)->orderBy('id', 'desc')->get();
        $penalty_period = $now->addDays(15)->format('Y-m-d');
        $owner = User::findOrFail($trip->owner_id);
        $renter = User::findOrFail($trip->renter_id);
        $renterAvailable = UserAvailable::where('user_id', $renter->id)->where('trip_id', $trip->id)->first();
        try{
            $this->paymentCancellation($tripBills);

            $trip['owner_confirm_trip'] = 'canceled';
            $trip['status'] = 'canceled';
            $trip->save();
            $owner['count_penalty_owner'] += 1;
            $owner['count_penalty_in_period'] += 1;
            $owner['penalty_period'] = $penalty_period;
            if($owner['count_penalty_in_period'] > 1){
                $owner['penalty_amount'] += 100;
            }
            $owner->save();
            $renterAvailable->delete();
            if($trip->status === 'started'){
                $carAvailable = CarAvailable::where('car_id', $trip->car_id)->where('trip_id', $trip->id)->first();
                $carAvailable->delete();
            }
        }catch (Exception $exception){
            throw new CustomException(SOMETHING_WENT_WRONG);
        }
        return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP_BUT_YOU_HAVE_PENALTY);
    }

    /**
     * @param $tripBills
     */
    private function paymentCancellation($tripBills)
    {
        foreach($tripBills as $tripBill){
            switch($tripBill){
                case($tripBill['trip_bill_status'] === 'accepted' && $tripBill['trip_total'] > 0):
                    $params = $this->refundWholeAmount($tripBill);
                    $clientResponse = $this->remoteXml($params);
                    $jsonResponse = $this->paymentParse($clientResponse);
                    break;
                case($tripBill['trip_bill_status'] === 'accepted' && $tripBill['trip_total'] == 0):
                    $tripBill['trip_bill_status'] = 'canceled';
                    $tripBill['trip_paid'] = false;
                    $tripBill->save();
                    continue 2;
                    break;
                case($tripBill['trip_bill_status'] === 'canceled' && $tripBill['trip_total'] == 0):
                    # case 5
                    continue 2;
                    break;
            }
            $jsonParams = $this->jsonParams($params);
            $this->cancelTripBill($tripBill, $jsonParams);
            if(isset($jsonResponse['auth']['tranref'])){
                $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
            }
            $tripBill->save();
        }
    }
}