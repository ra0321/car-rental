<?php

namespace App\Traits\Trip;

use App\Coupon;
use App\CouponUser;
use App\CustomPrice;
use App\Exceptions\CustomException;
use App\TripBill;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait TripCalculatorHelperTrait
 * @package App\Traits\Trip
 */
trait TripCalculatorHelperTrait
{
    /**
     * @param $data
     * @return bool
     */
    public function getTripType($data)
    {
        $pickup = $this->getPickupLocation($data);
        switch (true){
            case($pickup['on_airport']):
                $bookInstant = $data['car']->bookInstantly->on_airport;
                break;
            case($pickup['on_car_location']):
                $bookInstant = $data['car']->bookInstantly->on_car_location;
                break;
            case($pickup['on_guest_location']):
                $bookInstant = $data['car']->bookInstantly->on_guest_location;
                break;
            default:
                $bookInstant = true;
        }
        return $bookInstant;
    }

    /**
     * @param $data
     * @return |null
     */
    public function getDeliveryFee($data)
    {
        $pickup = $this->getPickupLocation($data);
        switch(true){
            case($pickup['on_airport']):
                $delivery_fee = $this->checkAirport($data['airport_id']);
                break;
            case($pickup['on_guest_location']):
                $delivery_fee = $this->checkGuestLocation($data['car'], count($data['priceByDay']), $data);
                break;
            default:
                $delivery_fee = null;
                break;
        }
        return $delivery_fee;
    }

    /**
     * @param $data
     * @param $tripBill
     * @throws CustomException
     */
    public function getDiscount($data, &$tripBill)
    {
        if(isset($data['promo_code'])){
            $promoCode = $this->getPromoCode($data);
        }
        $carDiscount = $this->getCarDiscount($data, $tripBill);
        $discounts['tripBill'] = $tripBill;
        !isset($promoCode) ?: $discounts['promoCode'] = $promoCode;
        !isset($carDiscount) ?: $discounts['carDiscount'] = $carDiscount;

        switch(count($discounts)){
            case 2:
                if(isset($discounts['carDiscount'])){
                    $ownerDiscount = round(($discounts['tripBill']['trip_price'] * $discounts['carDiscount']) / 100);
                    $tripBill['discount_amount'] = $ownerDiscount;
                }else{
                    $promoDiscount = $discounts['promoCode']->is_fixed ?
                        $discounts['promoCode']->discount_amount :
                        round(($discounts['tripBill']['trip_price'] * $discounts['promoCode']->discount_amount) / 100);
                    $tripBill['promo_code'] = $discounts['promoCode']->code;
                    $tripBill['promo_code_discount'] = $discounts['promoCode']->discount_amount;
                    $tripBill['promo_discount'] = $promoDiscount;
                    $tripBill['is_promo_fixed'] = $discounts['promoCode']->is_fixed;
                }
                $discountAmount = isset($tripBill['discount_amount']) ? $tripBill['discount_amount'] : $tripBill['promo_discount'];
                break;
            case 3:
                $ownerDiscount = isset($discounts['carDiscount']) ?
                    round(($discounts['tripBill']['trip_price'] * $discounts['carDiscount']) / 100) :
                    null;
                $promoDiscount = $discounts['promoCode']->is_fixed ?
                    $discounts['promoCode']->discount_amount :
                    round(($discounts['tripBill']['trip_price'] * $discounts['promoCode']->discount_amount) / 100);
                if($ownerDiscount > $promoDiscount){
                    $tripBill['discount_amount'] = $ownerDiscount;
                }else{
                    $tripBill['promo_code'] = $discounts['promoCode']->code;
                    $tripBill['promo_code_discount'] = $discounts['promoCode']->discount_amount;
                    $tripBill['promo_discount'] = $promoDiscount;
                    $tripBill['is_promo_fixed'] = $discounts['promoCode']->is_fixed;
                    $tripBill['discount_week'] = null;
                    $tripBill['discount_month'] = null;
                }
                $discountAmount = isset($tripBill['discount_amount']) ? $tripBill['discount_amount'] : $tripBill['promo_discount'];
                break;
            default:
                $discountAmount = 0;
                break;
        }
        $tripBill['price_with_discount'] = $tripBill['trip_price'] - $discountAmount;
    }

    /**
     * @param $tripBill
     */
    public function tripTotalEarning($tripBill)
    {
        if($tripBill['promo_code']){
            $tripBill['trip_total'] = $tripBill['price_with_discount'] + $tripBill['delivery_fee'];
            $tripBill['owner_earning'] = floor(($tripBill['trip_price'] * 85) / 100);
            $tripBill['esar_earning'] = $tripBill['trip_total'] - $tripBill['owner_earning'];
        }else{
            $tripBill['trip_total'] = $tripBill['price_with_discount'] + $tripBill['delivery_fee'];
            $tripBill['owner_earning'] = floor(($tripBill['trip_total'] * 85) / 100);
            $tripBill['esar_earning'] = $tripBill['trip_total'] - $tripBill['owner_earning'];
        }

    }

    /**
     * @param TripBill $tripBill
     * @throws CustomException
     */
    public function checkFixPromoCode(TripBill $tripBill)
    {
        if($tripBill->promo_discount * 2 > $tripBill->trip_price){
            throw new CustomException(CANNOT_USE_THIS_PROMO_CODE);
        }
    }

    /**
     * @param $data
     * @return array
     */
    private function getPickupLocation($data)
    {
        $pickup = [];
        $pickup['on_airport'] = isset($data['pick_on_airport']) ? $data['pick_on_airport'] : null;
        $pickup['on_guest_location'] = isset($data['pick_on_guest_location']) ? $data['pick_on_guest_location'] : null;
        $pickup['on_car_location'] = isset($data['pick_on_car_location']) ? $data['pick_on_car_location'] : null;
        return $pickup;
    }

    /**
     * @param $data
     * @return Coupon|Model|null
     * @throws CustomException
     */
    private function getPromoCode($data)
    {
        if($data['promo_code']){
            $now = Carbon::now()->getTimestamp();
            $promoCode = Coupon::where('code', $data['promo_code'])->first();
            if(!$promoCode){
                throw new CustomException(YOU_ENTER_INVALID_PROMO_CODE);
            }
            $userUsagesPromoCode = CouponUser::whereUserId($data['user']->id)->where('coupon_id', $promoCode->id)->count();
            if($userUsagesPromoCode >= $promoCode->max_uses_user){
                throw new CustomException(YOU_EXCEEDED_MAXIMAL_NUMBER_OF_USAGES_FOR_THIS_PROMO_CODE);
            }
            if($now > Carbon::parse($promoCode->expires_at)->getTimestamp()){
                throw new CustomException(PROMO_CODE_IS_EXPIRED);
            }
        }else{
            $promoCode = null;
        }
        return $promoCode;
    }

    /**
     * @param $data
     * @param $tripBill
     * @return mixed|string|null
     */
    private function getCarDiscount($data, &$tripBill)
    {
        $basicPrice = CustomPrice::where('car_id', $data['car']->id)->where('price_until_date', null)->firstOrFail();
        if(count($data['priceByDay']) >= 7){
            $carDiscount = $basicPrice->discount_week;
            $tripBill['discount_week'] = $carDiscount;
        }
        if(count($data['priceByDay']) >= 30){
            $carDiscount = $basicPrice->discount_month;
            $tripBill['discount_month'] = $carDiscount;
        }
        return isset($carDiscount) ? $carDiscount : null;
    }
}