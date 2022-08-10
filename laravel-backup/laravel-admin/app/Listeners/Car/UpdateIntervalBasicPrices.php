<?php

namespace App\Listeners\Car;

use Carbon\Carbon;
use App\CustomPrice;
use App\Traits\UpdatePrice;
use App\Events\Car\UpdateBasicPrices;

class UpdateIntervalBasicPrices
{
    use UpdatePrice;
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
     * Handle the event.
     *
     * @param  UpdateBasicPrices  $event
     * @return void
     */
    public function handle(UpdateBasicPrices $event)
    {
        if(Request()->is_automatic_price === 1 || Request()->is_automatic_price === true || Request()->is_automatic_price === "true"){
            $data = Request()->only('is_automatic_price', 'price');
        }else{
            $data = Request()->only('is_automatic_price', 'price', 'discount_week', 'discount_month');
        }

        $now = Carbon::now()->format('Y-m-d');
        foreach($event->allPrices as $basicPrice){
            $isAutomaticPrice = isset($data['is_automatic_price']) ? $data['is_automatic_price'] : $basicPrice['is_automatic_price'];
            $price = isset($data['price']) ? $data['price'] : $basicPrice['price'];
            //dd($price);
            $discountWeek = isset($data['discount_week']) ? $data['discount_week'] : $basicPrice['discount_week'];
            $discountMonth = isset($data['discount_month']) ? $data['discount_month'] : $basicPrice['discount_month'];
            switch($basicPrice){
                // case where is beginning date of old interval equal with now()
                case(Carbon::parse($basicPrice['price_from_date'])->eq(Carbon::parse($now))):
                    if($basicPrice['price'] === null){
                        if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['discount_week'] = 15;
                            $basicPrice['discount_month'] = 25;
                        }else{
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['discount_week'] = $discountWeek;
                            $basicPrice['discount_month'] = $discountMonth;
                        }
                        $basicPrice->save();
                    }else{
                        if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['price'] = $price;
                            $basicPrice['discount_week'] = 15;
                            $basicPrice['discount_month'] = 25;
                        }else{
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['price'] = $price;
                            $basicPrice['discount_week'] = $discountWeek;
                            $basicPrice['discount_month'] = $discountMonth;
                        }
                        $basicPrice->save();
                    }
                    break;
                // case where is beginning date of old interval less then now()
                // and the ending date of old interval bigger then now()
                case(Carbon::parse($basicPrice['price_from_date'])->lt(Carbon::now()) && Carbon::parse($basicPrice['price_until_date'])->gt(Carbon::now())):
                    $oldDate = $basicPrice['price_until_date'];
                    $basicPrice['price_until_date'] = Carbon::now()->subDay()->format('Y-m-d');
                    $basicPrice->save();

                    $newPrice = new CustomPrice();
                    if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                        $event->car->updateLoop($data, $newPrice);
                        $newPrice['car_id'] = $event->car->id;
                        $newPrice['is_automatic_price'] = $isAutomaticPrice;
                        $newPrice['discount_week'] = 15;
                        $newPrice['discount_month'] = 25;
                        $newPrice['price_from_date'] = Carbon::now()->format('Y-m-d');
                        $newPrice['price_until_date'] = $oldDate;
                    }else{
                        $event->car->updateLoop($data, $newPrice);
                        $newPrice['car_id'] = $event->car->id;
                        $newPrice['is_automatic_price'] = $isAutomaticPrice;
                        $newPrice['price_from_date'] = Carbon::now()->format('Y-m-d');
                        $newPrice['price_until_date'] = $oldDate;
                    }
                    $newPrice->save();
                    break;
                // case where is beginning date of old interval bigger then now()
                case(Carbon::parse($basicPrice['price_from_date'])->gt(Carbon::now()) && $basicPrice['price_until_date'] !== null):
                    if($basicPrice['price'] === null){
                        if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['discount_week'] = 15;
                            $basicPrice['discount_month'] = 25;
                        }else{
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['discount_week'] = $discountWeek;
                            $basicPrice['discount_month'] = $discountMonth;
                        }
                        $basicPrice->save();
                    }else{
                        if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['price'] = $price;
                            $basicPrice['discount_week'] = 15;
                            $basicPrice['discount_month'] = 25;
                        }else{
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['price'] = $price;
                            $basicPrice['discount_week'] = $discountWeek;
                            $basicPrice['discount_month'] = $discountMonth;
                        }
                        $basicPrice->save();
                    }
                    break;
                // case where is beginning date of old interval less then now()
                // and the ending date of old interval is null
                case(Carbon::parse($basicPrice['price_from_date'])->lt(Carbon::now()) && $basicPrice['price_until_date'] === null):
                    $basicPrice['price_until_date'] = Carbon::now()->subDay()->format('Y-m-d');
                    $basicPrice->save();

                    $newPrice = new CustomPrice();
                    if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                        $event->car->updateLoop($data, $newPrice);
                        $newPrice['car_id'] = $event->car->id;
                        $newPrice['is_automatic_price'] = $isAutomaticPrice;
                        $newPrice['price'] = $price;
                        $newPrice['discount_week'] = 15;
                        $newPrice['discount_month'] = 25;
                        $newPrice['price_from_date'] = Carbon::now()->format('Y-m-d');
                    }else{
                        $event->car->updateLoop($data, $newPrice);
                        $newPrice['car_id'] = $event->car->id;
                        $newPrice['is_automatic_price'] = $isAutomaticPrice;
                        $newPrice['price'] = $price;
                        $newPrice['price_from_date'] = Carbon::now()->format('Y-m-d');
                    }
                    $newPrice->save();
                    break;
                // case where is beginning date of old interval bigger then now()
                // and the ending date of old interval is null
                case(Carbon::parse($basicPrice['price_from_date'])->gt(Carbon::now()) && $basicPrice['price_until_date'] === null):
                    if($basicPrice['price'] === null){
                        if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['discount_week'] = 15;
                            $basicPrice['discount_month'] = 25;
                        }else{
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['discount_week'] = $discountWeek;
                            $basicPrice['discount_month'] = $discountMonth;
                        }
                        $basicPrice->save();
                    }else{
                        if($isAutomaticPrice === 1 || $isAutomaticPrice === true || $isAutomaticPrice === "true"){
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['price'] = $price;
                            $basicPrice['discount_week'] = 15;
                            $basicPrice['discount_month'] = 25;
                        }else{
                            $basicPrice['is_automatic_price'] = $isAutomaticPrice;
                            $basicPrice['price'] = $price;
                            $basicPrice['discount_week'] = $discountWeek;
                            $basicPrice['discount_month'] = $discountMonth;
                        }
                        $basicPrice->save();
                    }
                    break;
            }
        }
    }
}
