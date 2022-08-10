<?php

namespace App\Transformers;

use App\Helpers\Currency\CurrencyHelper;
use App\TripBill;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class TripBillTransformer
 * @package App\Transformers
 */
class TripBillTransformer extends TransformerAbstract
{

    /**
     * @param TripBill $tripBill
     * @return array
     */
    public function transform(TripBill $tripBill)
    {
        return [
            "tripId" => (integer)$tripBill->trip_id,
            "tripDays" => (integer)$tripBill->trip_days,
            "tripStartDate" => (string)Carbon::parse($tripBill->trip_start_date)->format('Y-m-d H:i:s'),
            "tripEndDate" => (string)Carbon::parse($tripBill->trip_end_date)->format('Y-m-d H:i:s'),
            "discountWeek" => isset($tripBill->discount_week) ? (integer)$tripBill->discount_week : null,
            "discountMonth" => isset($tripBill->discount_month) ? (integer)$tripBill->discount_month : null,
            "deposit" => isset($tripBill->deposit) ? CurrencyHelper::exchange((integer)$tripBill->deposit) : null,
            "promoCode" => isset($tripBill->promo_code) ? (string)$tripBill->promo_code : null,
            "promoCodeDiscount" => isset($tripBill->promo_code_discount) ? (integer)$tripBill->promo_code_discount : null,
            "promoDiscount" => isset($tripBill->promo_discount) ? CurrencyHelper::exchange((integer)$tripBill->promo_discount) : null,
            "isPromoFixed" => isset($tripBill->is_promo_fixed) ? (bool)$tripBill->is_promo_fixed : null,
            "averagePrice" => CurrencyHelper::exchange((integer)$tripBill->average_price),
            "deliveryFee" => isset($tripBill->delivery_fee) ? (integer)$tripBill->delivery_fee : null,
            "tripPrice" => CurrencyHelper::exchange((integer)$tripBill->trip_price),
            "priceWithDiscount" => isset($tripBill->price_with_discount) ? CurrencyHelper::exchange((integer)$tripBill->price_with_discount) : null,
            "priceWithPromoDiscount" => isset($tripBill->price_with_promo_discount) ? CurrencyHelper::exchange((integer)$tripBill->price_with_promo_discount) : null,
            "ownerEarning" => CurrencyHelper::exchange((integer)$tripBill->owner_earning),
            "tripTotal" => CurrencyHelper::exchange((integer)$tripBill->trip_total),
	        "bookedInstantly" => (boolean)$tripBill->booked_instantly,
        ];
    }
}
