<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripBillUpdateEvent;
use App\Exceptions\DynamicException;
use App\Traits\CalculatorTrip;
use App\Traits\Trip\TripCalculatorHelperTrait;
use App\Traits\UpdatePrice;
use App\TripBill;
use Carbon\Carbon;

/**
 * Class TripCalculatorUpdateEvent
 * @package App\Listeners\Trip
 */
class TripCalculatorUpdateEvent
{
    use CalculatorTrip, UpdatePrice, TripCalculatorHelperTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * @param TripBillUpdateEvent $event
	 *
	 * @return TripBill
	 * @throws DynamicException
	 */
	public function handle(TripBillUpdateEvent $event)
    {
        $event->data['oldTripBill'] = TripBill::where('trip_id', $event->data['trip']->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $tripBill = $this->tripPriceCalculationTwoDec($event->data);

        // TRIP FEE CALCULATION
        $tripBill->trip_price = $tripBill->trip_price - $event->data['oldTripBill']->trip_price;
        $tripBill->price_with_discount = $tripBill->trip_price;

        /*if(!$event->data['oldTripBill']->promo_code){
            // TRIP DISCOUNT CALCULATION
            $tripWeeklyDiscount = round(($tripBill->trip_price * $tripBill->discount_week) / 100);
            $tripMonthlyDiscount = round(($tripBill->trip_price * $tripBill->discount_month) / 100);
            // TRIP TOTAL CALCULATION
            if($tripWeeklyDiscount){
                $tripBill->price_with_discount = $tripBill->trip_price - $tripWeeklyDiscount;
            }
            if($tripMonthlyDiscount){
                $tripBill->price_with_discount = $tripBill->trip_price - $tripMonthlyDiscount;
            }
        }*/

        // TRIP DISCOUNT CALCULATION
        $tripWeeklyDiscount = round(($tripBill->trip_price * $tripBill->discount_week) / 100);
        $tripMonthlyDiscount = round(($tripBill->trip_price * $tripBill->discount_month) / 100);
        // TRIP TOTAL CALCULATION
        if($tripWeeklyDiscount){
            $tripBill->price_with_discount = $tripBill->trip_price - $tripWeeklyDiscount;
        }
        if($tripMonthlyDiscount){
            $tripBill->price_with_discount = $tripBill->trip_price - $tripMonthlyDiscount;
        }

        // TRIP TOTAL
        // trip total subtract old delivery fee and add new one
        $tripBill->trip_total = ($tripBill->trip_total - $event->data['oldTripBill']->trip_total);
        $tripBill->owner_earning = floor(($tripBill->trip_total * 85) / 100);
        $tripBill->esar_earning = $tripBill->trip_total - $tripBill->owner_earning;

        $tripBill->trip_id = $event->data['trip']->id;
	    $tripBill->trip_start_date = Carbon::parse($event->data['price_from_date'])->format('Y-m-d H:i:s');
	    $tripBill->trip_end_date = Carbon::parse($event->data['price_until_date'])->format('Y-m-d H:i:s');
        return $tripBill;
    }
}
