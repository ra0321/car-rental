<?php


namespace App\Traits\NewPayment\TripCancellation\SpecificCases;


use App\Exceptions\CustomException;

/**
 * Trait CancelTripLessThanSevenDaysTrait
 * @package App\Traits\NewPayment\TripCancellation\SpecificCases
 */
trait CancelTripLessThanSevenDaysTrait
{
    /**
     * @param $tripBills
     * @return mixed
     * @throws CustomException
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
}