<?php
namespace App\Traits;

use App\CustomPrice;
use Carbon\Carbon;

/**
 * Trait PriceForDay
 * @package App\Traits
 */
trait PriceForDay
{
    /**
     * @param $car
     * @param $date
     * @return mixed
     */
    public function getPriceForDay($car, $date)
    {
        $allPrices = $this->getAllPrices($car);
        $price = $this->getPrice($allPrices, $date);
        return $price;
    }

    /**
     * @param $car
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllPrices($car)
    {
        $allPrices = CustomPrice::where('car_id', $car->id)->orderBy('price_from_date', 'desc')->get();
        return $allPrices;
    }

    /**
     * @param $allPrices
     * @param $date
     * @return mixed
     */
    public function getPrice($allPrices, $date)
    {
        $date = Carbon::parse($date)->format('Y-m-d');
        foreach ($allPrices as $item){
            switch ($item){
                case(Carbon::parse($date)->gte(Carbon::parse($item['price_from_date']))
                    && Carbon::parse($date)->lte(Carbon::parse($item['price_until_date'])) && $item['price_until_date'] !== null):
                    $price = isset($item['price']) ? $item['price'] : $item['custom_price'];
                    break;
                case(Carbon::parse($date)->eq(Carbon::parse($item['price_from_date'])) && $item['price_until_date'] === null):
                    $price = isset($item['price']) ? $item['price'] : $item['custom_price'];
                    break;
                case(Carbon::parse($date)->gt(Carbon::parse($item['price_from_date'])) && $item['price_until_date'] === null):
                    $price = $item['price'];
                    break;
            }
        }
        return $price;
    }
}


