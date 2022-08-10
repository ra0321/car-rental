<?php

namespace App\Traits\Trip;

use App\ChatMessage;
use App\Events\Activity\AcceptModifyTripNotificationEvent;
use App\Events\Activity\UpdateTripNotificationEvent;
use App\Events\Prepare\PendingEmailEvent;
use App\Exceptions\CustomException;
use App\Exceptions\PaymentException;
use App\Helpers\EsarPushNotifications;
use Log;

/**
 * Trait ModificationTripTrait
 * @package App\Traits\Trip
 */
trait ModificationTripTrait
{
    /**
     * @param $trip_bill
     * @param $old_bill
     * @throws CustomException
     * @throws PaymentException
     */
    public function refundPartAmountModificationTrip($trip_bill, $old_bill)
    {
        $params = $this->refundPartAmount($trip_bill, $old_bill);
        $old_bill->trip_total = $old_bill->trip_total + $trip_bill->trip_total;
        $old_bill->esar_earning = $old_bill->esar_earning + $trip_bill->esar_earning;
        $old_bill->owner_earning = $old_bill->owner_earning + $trip_bill->owner_earning;
        $trip_bill->trip_total = 0;
        $trip_bill->esar_earning = 0;
        $trip_bill->owner_earning = 0;
        if(isset($params)){
            $clientResponse = $this->remoteXml($params);
            if(json_decode($clientResponse->getStatusCode(), true) === 200){
                $xml = simplexml_load_string($clientResponse->getBody());
            }else{
                throw new CustomException(SOMETHING_WENT_WRONG_WITH_PAYMENT);
            }
            $json = json_encode($xml);
            $jsonResponse = json_decode($json,TRUE);

            if($jsonResponse['auth']['status'] === "A"){
                $trip_bill['tran_ref'] = $jsonResponse['auth']['tranref'];
            }else{
                $errorMessage = $this->bankError[$jsonResponse['auth']['code']];
                Log::critical($errorMessage['message']['lang']['en']);
                throw new PaymentException($errorMessage);
            }
        }
    }

    public function sendingModificationNotification($trip, $user, $data)
    {
        # SEND MESSAGE
        $newMessage = new ChatMessage();
        $newMessage['chat_id'] = $trip->chat_id;
        $newMessage['user_id'] = $user->id;
        $newMessage['message'] = $data['message'];
        $newMessage->save();
        if($trip->booked_instantly){
            # SEND NOTIFICATION
            event(new AcceptModifyTripNotificationEvent($trip));
            # PUSH NOTIFICATION
            EsarPushnotifications::acceptChangeTripRequestOwner($trip);
            EsarPushnotifications::acceptChangeTripRequestRenter($trip);
        }else{
            # SEND REQUEST
            event(new UpdateTripNotificationEvent($trip));
            # PUSH NOTIFICATION
            EsarPushnotifications::changeTripRequestOwner($trip);
            EsarPushnotifications::changeTripRequestRenter($trip);
        }
        # SEND EMAIL
        event(new PendingEmailEvent('App\Events\NewMail\ModifyTripOwnerMailEvent', $trip->id));
        event(new PendingEmailEvent('App\Events\NewMail\ModifyTripRenterMailEvent', $trip->id));
    }
}