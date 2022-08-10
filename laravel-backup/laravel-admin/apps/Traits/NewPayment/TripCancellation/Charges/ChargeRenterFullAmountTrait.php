<?php

namespace App\Traits\NewPayment\TripCancellation\Charges;

use App\Exceptions\CustomException;
use App\Traits\ApiResponser;

trait ChargeRenterFullAmountTrait
{
    use ApiResponser;

    /**
     * @param $tripBills
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomException
     */
    public function fullCharge($tripBills)
    {
        try{
            $tripBills[0]['trip_bill_status'] = 'canceled';
            $tripBills[0]['trip_paid'] = false;
            $tripBills[0]->save();
        }catch (CustomException $exception){
            throw new CustomException(SOMETHING_WENT_WRONG);
        }
        return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }


    /**
     * @param $tripBills
     * @return \Illuminate\Http\JsonResponse
     * @throws CustomException
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
            }
        }catch (CustomException $exception){
            throw new CustomException(SOMETHING_WENT_WRONG);
        }
        return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }
}