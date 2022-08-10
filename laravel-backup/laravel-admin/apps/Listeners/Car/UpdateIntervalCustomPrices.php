<?php

namespace App\Listeners\Car;

use App\Exceptions\CustomException;
use Carbon\Carbon;
use App\CustomPrice;
use App\Traits\UpdatePrice;
use App\Traits\ApiResponser;
use App\Events\Car\UpdateCustomPrices;

/**
 * Class UpdateIntervalCustomPrices
 * @package App\Listeners\Car
 */
class UpdateIntervalCustomPrices
{
    use UpdatePrice, ApiResponser;
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
     * @param UpdateCustomPrices $event
     * @throws CustomException
     */
    public function handle(UpdateCustomPrices $event)
    {
        $dates = $this->dates();
        $request = Request()->all();
        // all price intervals for car
        $existingPrices = CustomPrice::where('car_id', $event->car->id)->orderBy('price_from_date', 'desc')->get();

        // all price intervals related with new custom price
        $listOfItems = [];
        foreach ($existingPrices as $existingPrice){
            switch($existingPrice){
                case(Carbon::parse($existingPrice->price_from_date)->eq(Carbon::parse($dates['newStartDate']))):
                    array_push($listOfItems, $existingPrice);
                    break;
                case(Carbon::parse($existingPrice->price_until_date)->eq(Carbon::parse($dates['newEndDate']))):
                    array_push($listOfItems, $existingPrice);
                    break;
                case(!Carbon::parse($existingPrice->price_from_date)->gt(Carbon::parse($dates['newEndDate'])) && !Carbon::parse($existingPrice->price_until_date)->lt(Carbon::parse($dates['newStartDate']))):
                    array_push($listOfItems, $existingPrice);
                    break;
                case(Carbon::parse($dates['newEndDate'])->gt(Carbon::parse($existingPrice->price_from_date)) && $existingPrice->price_until_date === null):
                    array_push($listOfItems, $existingPrice);
                    break;
            }
        }

        foreach($listOfItems as $item){
            switch ($item){
                // case where is beginning date of old interval equal with beginning date of new interval
                // and the ending date of old interval equal with ending date of new interval
                case(Carbon::parse($item['price_from_date'])->eq(Carbon::parse($dates['newStartDate'])) && Carbon::parse($item['price_until_date'])->eq(Carbon::parse($dates['newEndDate']))):
                    if($item['custom_price'] == $request['custom_price']){
                        throw new CustomException(YOU_HAVE_ENTERED_SAME_PRICE_FOR_THE_SAME_PERIOD);
                        break;
                    }else{
                        $this->archiveCustomPrice($item);
                        $item->delete();
                        break;
                    }
                    break;
                // case where is beginning date of old interval bigger then beginning date of new interval
                // and the ending date of old interval less then ending date of new interval
                // this data goes to ArchivedPrices table
                case (Carbon::parse($item['price_from_date'])->gte(Carbon::parse($dates['newStartDate'])) && Carbon::parse($item['price_until_date'])->lte(Carbon::parse($dates['newEndDate'])) && $item['price_until_date'] !== null):
                    $this->archiveCustomPrice($item);
                    $item->delete();
                    break;
                // case where is beginning date of old interval less then beginning date of new interval
                // and the ending date of old interval less then ending date of new interval
                case(Carbon::parse($item['price_from_date'])->lte(Carbon::parse($dates['newStartDate'])) && Carbon::parse($item['price_until_date'])->lte(Carbon::parse($dates['newEndDate'])) && $item['price_until_date'] !== null):
                    $item['price_until_date'] = Carbon::parse($dates['newStartDateSubOne'])->format('Y-m-d');
                    $item->save();
                    break;
                // case where is beginning date of old interval bigger then beginning date of new interval
                // and the ending date of old interval bigger then ending date of new interval
                case(Carbon::parse($item['price_from_date'])->gte(Carbon::parse($dates['newStartDate'])) && Carbon::parse($item['price_until_date'])->gte(Carbon::parse($dates['newEndDate'])) && $item['price_until_date'] !== null):
                    $item['price_from_date'] = Carbon::parse($dates['newEndDateAddOne'])->format('Y-m-d');
                    $item->save();
                    break;
                // case where is beginning date of old interval less then beginning date of new interval
                // and the ending date of old interval bigger then ending date of new interval
                case(Carbon::parse($item['price_from_date'])->lte(Carbon::parse($dates['newStartDate'])) && Carbon::parse($item['price_until_date'])->gte(Carbon::parse($dates['newEndDate'])) && $item['price_until_date'] !== null):
                    $intervalEndDate = Carbon::parse($item['price_until_date'])->format('Y-m-d');
                    $intervalPrice = $item['custom_price'];
                    $item['price_until_date'] = Carbon::parse($dates['newStartDateSubOne'])->format('Y-m-d');
                    $item->save();
                    $updatedInterval = new CustomPrice();
                    $updatedInterval['car_id'] = $event->car->id;
                    $updatedInterval['is_automatic_price'] = $item['is_automatic_price'];
                    $updatedInterval['discount_week'] = $item['discount_week'];
                    $updatedInterval['discount_month'] = $item['discount_month'];
                    $updatedInterval['custom_price'] = $intervalPrice;
                    $updatedInterval['price_from_date'] = Carbon::parse($dates['newEndDateAddOne'])->format('Y-m-d');
                    $updatedInterval['price_until_date'] = Carbon::parse($intervalEndDate)->format('Y-m-d');
                    $updatedInterval->save();
                    break;
                case(Carbon::parse($dates['newStartDate'])->lt(Carbon::parse($item['price_from_date'])) && $item['price_until_date'] === null):
                    $this->archiveCustomPrice($item);
                    $item->delete();
                    $newBasicPrice = new CustomPrice();
                    $newBasicPrice->car_id = $item['car_id'];
                    $newBasicPrice->price_from_date = Carbon::parse($dates['newEndDateAddOne'])->format('Y-m-d');
                    $newBasicPrice->price_until_date = null;
                    $newBasicPrice->price = $item['price'];
                    $newBasicPrice->discount_week = $item['discount_week'];
                    $newBasicPrice->discount_month = $item['discount_month'];
                    $newBasicPrice->is_automatic_price = $item['is_automatic_price'];
                    $newBasicPrice->save();
                    break;
                // case where changing beginning of basic price
                case(Carbon::parse($item['price_from_date'])->lt(Carbon::parse($dates['newStartDate'])) && $item['price_until_date'] === null):
                    $newBasicPrice = new CustomPrice();
                    $item['price_until_date'] = Carbon::parse($dates['newStartDateSubOne'])->format('Y-m-d');
                    $item->save();
                    $newBasicPrice->car_id = $item['car_id'];
                    $newBasicPrice->price_from_date = Carbon::parse($dates['newEndDateAddOne'])->format('Y-m-d');
                    $newBasicPrice->price_until_date = null;
                    $newBasicPrice->price = $item['price'];
                    $newBasicPrice->discount_week = $item['discount_week'];
                    $newBasicPrice->discount_month = $item['discount_month'];
                    $newBasicPrice->is_automatic_price = $item['is_automatic_price'];
                    $newBasicPrice->save();
                    break;
                case(Carbon::parse($item['price_from_date'])->eq(Carbon::parse($dates['newStartDate'])) && $item['price_until_date'] === null):
                    $this->archiveCustomPrice($item);
                    $item->delete();
                    $updateBasicPriceInterval = new CustomPrice();
                    $updateBasicPriceInterval['car_id'] = $event->car->id;
                    $updateBasicPriceInterval['is_automatic_price'] = $item['is_automatic_price'];
                    $updateBasicPriceInterval['price'] = $item['price'];
                    $updateBasicPriceInterval['price_from_date'] = Carbon::parse($dates['newEndDateAddOne'])->format('Y-m-d');
                    $updateBasicPriceInterval->save();
                    break;
            }
        }
    }
}
