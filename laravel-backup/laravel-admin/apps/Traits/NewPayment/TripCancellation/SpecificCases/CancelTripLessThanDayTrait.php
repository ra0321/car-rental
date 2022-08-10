<?php

namespace App\Traits\NewPayment\TripCancellation\SpecificCases;

use App\Traits\NewPayment\TripCancellation\Charges\ChargeRenterFullAmountTrait;
use App\Traits\NewPayment\TripCancellation\Charges\ChargeRenterWithPenaltyTrait;

/**
 * Trait CancelTripLessThanDayTrait
 * @package App\Traits\NewPayment\TripCancellation\SpecificCases
 */
trait CancelTripLessThanDayTrait
{
    use ChargeRenterFullAmountTrait, ChargeRenterWithPenaltyTrait;

    /**
     * @param $tripBills
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CustomException
     */
    public function lessThanDay($tripBills)
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
    }
}