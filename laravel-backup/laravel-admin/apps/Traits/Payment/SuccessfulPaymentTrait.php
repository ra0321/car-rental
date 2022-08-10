<?php

namespace App\Traits\Payment;

use App\Coupon;
use App\CouponUser;
use App\Events\Activity\AcceptedTripEvent;
use App\Events\Activity\AcceptModifyTripNotificationEvent;
use App\Events\Activity\PendingTripEvent;
use App\Events\Activity\UpdateTripNotificationEvent;
use App\Events\Prepare\PendingEmailEvent;
use App\Events\Trip\TripSendMessageEvent;
use App\Helpers\EsarPushNotifications;
use Exception;

/**
 * Trait SuccessfulPaymentTrait
 * @package App\Traits\Payment
 */
trait SuccessfulPaymentTrait
{

    /**
     * @param $paramsForSuccessPayment
     * @throws Exception
     */
    public function finishPayment($paramsForSuccessPayment)
    {
        if(isset($paramsForSuccessPayment['trip_bill']['promo_code'])){
            $coupon = Coupon::where('code', $paramsForSuccessPayment['trip_bill']['promo_code'])->first();
            $userCoupon = new CouponUser();
            $userCoupon->user_id = $paramsForSuccessPayment['trip']['renter_id'];
            $userCoupon->trip_id = $paramsForSuccessPayment['trip']['id'];
            $userCoupon->coupon_id = $coupon->id;
        }

        try{
            $paramsForSuccessPayment['trip_bill']['trip_paid'] = true;
            $paramsForSuccessPayment['trip_bill']['trip_bill_status'] = 'accepted';
            $paramsForSuccessPayment['trip_bill']['tran_ref'] = $paramsForSuccessPayment['transDetail']['transaction']['id'];
            $paramsForSuccessPayment['trip_bill']->save();
            isset($userCoupon) ? $userCoupon->save() : null;
        }catch(Exception $e){
            // TODO something with this exception
            throw new Exception($e->getMessage(), $e->getCode());
        }

        $paramsForSuccessPayment['trip']->booked_instantly ?
            $this->bookedInstantlyAllKindNotifications($paramsForSuccessPayment) :
            $this->pendingTripAllKindNotifications($paramsForSuccessPayment);
    }

    /**
     * @param $paramsForSuccessPayment
     * @throws Exception
     */
    public function finishAntiFraudPayment($paramsForSuccessPayment)
    {
        try{
            $paramsForSuccessPayment['trip_bill']['trip_paid'] = true;
            $paramsForSuccessPayment['trip_bill']['trip_bill_status'] = 'on hold';
            $paramsForSuccessPayment['trip_bill']['tran_ref'] = $paramsForSuccessPayment['transDetail']['transaction']['id'];
            $paramsForSuccessPayment['trip_bill']->save();
        }catch(Exception $e){
            // TODO something with this exception
            throw new Exception($e->getMessage(), $e->getCode());
        }
        event(new PendingEmailEvent('App\Events\Mail\AntiFraud\RenterAntiFraudTripEvent', $paramsForSuccessPayment['trip']['id']));
        event(new PendingEmailEvent('App\Events\Mail\AntiFraud\AdminAntiFraudTripEvent', $paramsForSuccessPayment['trip']['id']));
    }

    /**
     * @param $paramsForSuccessPayment
     */
    private function bookedInstantlyAllKindNotifications($paramsForSuccessPayment)
    {
        # SEND MESSAGE
        event(new TripSendMessageEvent($paramsForSuccessPayment['trip'], $paramsForSuccessPayment['message']));
        if($paramsForSuccessPayment['count'] === 1){
            # SEND EMAILS TO USERS
            event(new PendingEmailEvent('App\Events\NewMail\BookedInstantlyOwnerMailEvent', $paramsForSuccessPayment['trip']['id']));
            event(new PendingEmailEvent('App\Events\NewMail\BookedInstantlyRenterMailEvent', $paramsForSuccessPayment['trip']['id']));
            # SEND EMAILS TO ADMIN
            event(new PendingEmailEvent('App\Events\Mail\Admin\BookedInstantlyAdminEvent', $paramsForSuccessPayment['trip']['id']));
            if($paramsForSuccessPayment['timeToTrip'] < 24){
                // SEND UPCOMING TRIP EMAIL
                event(new PendingEmailEvent('App\Events\NewMail\UpcomingTripOwnerMailEvent', $paramsForSuccessPayment['trip']['id']));
                event(new PendingEmailEvent('App\Events\NewMail\UpcomingTripRenterMailEvent', $paramsForSuccessPayment['trip']['id']));
            }
            EsarPushnotifications::tripBookedInstantlyOwner($paramsForSuccessPayment['trip'],$paramsForSuccessPayment['user']);
            EsarPushnotifications::tripBookedInstantlyRenter($paramsForSuccessPayment['trip'],$paramsForSuccessPayment['user']);
            # SEND NOTIFICATION
            event(new AcceptedTripEvent($paramsForSuccessPayment['trip']));
            EsarPushnotifications::acceptedTripOwner($paramsForSuccessPayment['trip']);
            EsarPushnotifications::acceptedTripRenter($paramsForSuccessPayment['trip']);
        }else{
            # SEND NOTIFICATION
            event(new AcceptModifyTripNotificationEvent($paramsForSuccessPayment['trip']));
            # SEND EMAIL TO USERS
            event(new PendingEmailEvent('App\Events\NewMail\AcceptTripModificationOwnerMailEvent', $paramsForSuccessPayment['trip']['id']));
            event(new PendingEmailEvent('App\Events\NewMail\AcceptTripModificationRenterMailEvent', $paramsForSuccessPayment['trip']['id']));
            if($paramsForSuccessPayment['timeToTrip'] < 24){
                # SEND UPCOMING TRIP EMAIL
                event(new PendingEmailEvent('App\Events\NewMail\UpcomingTripOwnerMailEvent', $paramsForSuccessPayment['trip']['id']));
                event(new PendingEmailEvent('App\Events\NewMail\UpcomingTripRenterMailEvent', $paramsForSuccessPayment['trip']['id']));
            }
            EsarPushnotifications::acceptChangeTripRequestOwner($paramsForSuccessPayment['trip']);
            EsarPushnotifications::acceptChangeTripRequestRenter($paramsForSuccessPayment['trip']);
        }
    }

    /**
     * @param $paramsForSuccessPayment
     */
    private function pendingTripAllKindNotifications($paramsForSuccessPayment)
    {
        // SEND MESSAGE
        event(new TripSendMessageEvent($paramsForSuccessPayment['trip'], $paramsForSuccessPayment['message']));
        if($paramsForSuccessPayment['count'] === 1){
            // NEW TRIP
            # SEND EMAILS TO USERS
            event(new PendingEmailEvent('App\Events\NewMail\TripRequestOwnerMailEvent', $paramsForSuccessPayment['trip']['id']));
            event(new PendingEmailEvent('App\Events\NewMail\TripRequestRenterMailEvent', $paramsForSuccessPayment['trip']['id']));
            # SEND EMAILS TO ADMIN
            event(new PendingEmailEvent('App\Events\Mail\Admin\PendingTripAdminEvent', $paramsForSuccessPayment['trip']['id']));
            // SEND REQUEST
            event(new PendingTripEvent($paramsForSuccessPayment['trip']));
            EsarPushnotifications::pendingTripOwner($paramsForSuccessPayment['trip']);
            EsarPushnotifications::pendingTripRenter($paramsForSuccessPayment['trip']);
        }else{
            # MODIFICATION OF TRIP
            # SEND NOTIFICATION TO USERS
            event(new UpdateTripNotificationEvent($paramsForSuccessPayment['trip']));
            // SEND EMAIL TO USERS
            event(new PendingEmailEvent('App\Events\NewMail\ModifyTripOwnerMailEvent', $paramsForSuccessPayment['trip']['id']));
            event(new PendingEmailEvent('App\Events\NewMail\ModifyTripRenterMailEvent', $paramsForSuccessPayment['trip']['id']));
            # SEND EMAILS TO ADMIN
            event(new PendingEmailEvent('App\Events\Mail\Admin\ModificationTripAdminEvent', $paramsForSuccessPayment['trip']['id']));
            EsarPushnotifications::changeTripRequestOwner($paramsForSuccessPayment['trip']);
            EsarPushnotifications::changeTripRequestRenter($paramsForSuccessPayment['trip']);
        }
    }
}