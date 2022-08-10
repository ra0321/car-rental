<?php


namespace App\Traits\NewPayment\TripCancellation\Charges;


use App\Exceptions\CustomException;

/**
 * Trait ChargeRenterWithPenaltyTrait
 * @package App\Traits\NewPayment\TripCancellation\Charges
 */
trait ChargeRenterWithPenaltyTrait
{
    /**
     * @param $tripBills
     * @return mixed
     * @throws CustomException
     */
    public function chargeWithPenalty($tripBills)
    {
        try{
            foreach ($tripBills as $k => $tripBill){
                if($k === 0){
                    $params = $this->refundLessOneDay($tripBill);
                    $clientResponse = $this->remoteXml($params);
                    $jsonResponse = $this->paymentParse($clientResponse);
                    $jsonParams = $this->jsonParams($params);
                    $tripBill = $this->cancelTripBill($tripBill, $jsonParams);
                    if(isset($jsonResponse['auth']['tranref'])){
                        $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
                    }
                    $tripBill->save();
                }else{
                    if($tripBill->trip_total > 0){
                        $params = $this->refundWithSecondPenalty($tripBill);
                        $clientResponse = $this->remoteXml($params);
                        $jsonResponse = $this->paymentParse($clientResponse);
                        $jsonParams = $this->jsonParams($params);
                        $tripBill = $this->cancelTripBill($tripBill, $jsonParams);
                        if(isset($jsonResponse['auth']['tranref'])){
                            $tripBill['tran_ref'] = $jsonResponse['auth']['tranref'];
                        }
                    }else{
                        $tripBill['trip_bill_status'] = 'canceled';
                        $tripBill['trip_paid'] = false;
                        $tripBill['trip_total'] = 0;
                        $tripBill['owner_earning'] = 0;
                        $tripBill['esar_earning'] = 0;
                    }
                    $tripBill->save();
                }
            }
        }catch (CustomException $exception){
            throw new CustomException(SOMETHING_WENT_WRONG);
        }
        return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }

    /**
     * @param $tripBills
     * @return mixed
     * @throws CustomException
     */
    public function chargeWithPenaltyWithModification($tripBills)
    {
        $minForRefund = ($tripBills[0]['trip_total'] * 0.15) + ($tripBills[0]['average_price'] / 2);
        if($tripBills[0]['trip_bill_status'] === 'accepted' && $minForRefund < $tripBills[0]['trip_total']){
            $this->refundFromBothBills($tripBills);
        }else{
            $this->chargeWithPenalty(array_reverse($tripBills->all()));
        }
        return $this->successResponseWithMessage(YOU_SUCCESSFULLY_CANCELED_TRIP);
    }

    /**
     * @param $tripBills
     * @throws CustomException
     */
    public function refundFromBothBills($tripBills)
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
    }
}