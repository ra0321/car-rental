<?php

namespace App\Listeners\Trip;

use App\Exceptions\DynamicException;
use App\Traits\Trip\TripCalculatorHelperTrait;
use App\Traits\UpdatePrice;
use App\Traits\CalculatorTrip;
use Carbon\Carbon;
use PDOException;

/**
 * Class TripCalculatorEvent
 * @package App\Listeners\Trip
 */
class TripCalculatorEvent
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
     * @param $event
     * @throws DynamicException
     */
    public function handle($event)
    {
        $tripBill = $this->tripPriceCalculationTwoDec($event->data);

        $tripBill->trip_id = $event->data['trip']['id'];
        $tripBill->trip_start_date = Carbon::parse($event->data['price_from_date'])->format('Y-m-d H:i:s');
        $tripBill->trip_end_date = Carbon::parse($event->data['price_until_date'])->format('Y-m-d H:i:s');
        try{
	        $tripBill->save();
        }catch(PDOException $exception){
        	$error_message = $exception->getMessage();
        	$error_code = (int)$exception->getCode();
        	throw new PDOException($error_message, $error_code);
        }

    }
}
