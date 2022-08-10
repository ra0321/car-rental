<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TripBills
 *
 * @property-read \App\Trip $trip
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $trip_id
 * @property int $trip_days
 * @property string $trip_start_date
 * @property string $trip_end_date
 * @property int|null $discount_week
 * @property int|null $discount_month
 * @property int|null $deposit
 * @property string|null $promo_code
 * @property int|null $promo_code_discount
 * @property int|null $promo_discount
 * @property int $average_price
 * @property float|null $service_fee
 * @property int|null $delivery_fee
 * @property int $trip_price
 * @property int|null $price_with_discount
 * @property int|null $price_with_promo_discount
 * @property int $owner_earning
 * @property int $esar_earning
 * @property int $trip_total
 * @property int $esar_paid
 * @property string|null $esar_paid_date
 * @property int|null $booked_instantly
 * @property int $trip_paid
 * @property string|null $order_ref
 * @property string|null $tran_ref
 * @property string|null $trip_bill_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereAveragePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereBookedInstantly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereDeliveryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereDiscountMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereDiscountWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereEsarEarning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereEsarPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereEsarPaidDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereOrderRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereOwnerEarning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills wherePriceWithDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills wherePriceWithPromoDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills wherePromoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills wherePromoCodeDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills wherePromoDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTranRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripBillStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereTripTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TripBills whereUpdatedAt($value)
 */
class TripBills extends Model
{
    protected $table = 'trip_bills';
    protected $appends = ['price_per_day'];
	/**
	 * @var array
	 */
	protected $fillable = [
        'esar_paid', 'esar_paid_date'
	];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function getPricePerDayAttribute(){
        return $this->trip_price / $this->trip_days;
    }
}
