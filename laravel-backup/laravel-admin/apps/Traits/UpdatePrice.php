<?php

namespace App\Traits;

use App\ArchivedPrice;
use App\CustomPrice;
use Carbon\Carbon;

/**
 * Trait UpdatePrice
 * @package App\Traits
 */
trait UpdatePrice
{
    /**
     * @var
     */
    protected $car;

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function oldPrice()
    {
        $oldPrice = CustomPrice::where('car_id', $this->car->id)->where('price_until_date', null)->orderBy('id', 'desc')->first();
        return $oldPrice;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allBasicPrices()
    {
        $basicPrices = CustomPrice::where('car_id', $this->car->id)->where('custom_price', null)->orderBy('price_from_date', 'desc')->get();
        return $basicPrices;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allPrices()
    {
        $allPrices = CustomPrice::where('car_id', $this->car->id)->orderBy('price_from_date', 'desc')->get();
        return $allPrices;
    }

    /**
     *
     */
    public function updateOldPrice()
    {
        $oldPrice = $this->oldPrice();
        $price_from_date = Carbon::parse($oldPrice['price_from_date']);
        $priceDate = Carbon::now()->subDay();
        if($price_from_date->gte($priceDate)){
            $this->archivePrice($oldPrice);
            $oldPrice->delete();
        }else{
            $oldPrice['price_until_date'] = $priceDate;
            $oldPrice->save();
        }
    }

    /**
     * @param $item
     */
    public function archiveCustomPrice($item)
    {
        $this->archivePrice($item);
    }

    /**
     * @return array
     */
    public function dates()
    {
        $request = Request()->all();
        $dates = [];
        $dates['newStartDate'] = isset($request['price_from_date']) ? Carbon::parse($request['price_from_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $dates['newEndDate'] = isset($request['price_until_date']) ? Carbon::parse($request['price_until_date'])->format('Y-m-d') : null;
        $dates['newStartDateSubOne'] = Carbon::parse($dates['newStartDate'])->subDay()->format('Y-m-d');
        $dates['newEndDateAddOne'] = isset($dates['newEndDate']) ? Carbon::parse($dates['newEndDate'])->addDay()->format('Y-m-d') : null;
        return $dates;
    }

    /**
     * @param $oldPrice
     */
    private function archivePrice($oldPrice)
    {
        $newArchive = new ArchivedPrice();
        $newArchive['car_id'] = $oldPrice['car_id'];
        $newArchive['is_automatic_price'] = $oldPrice['is_automatic_price'];
        $newArchive['price'] = $oldPrice['price'];
        $newArchive['discount_week'] = $oldPrice['discount_week'];
        $newArchive['discount_month'] = $oldPrice['discount_month'];
        $newArchive['price_from_date'] = $oldPrice['price_from_date'];
        $newArchive['price_until_date'] = $oldPrice['price_until_date'];
        $newArchive['custom_price'] = $oldPrice['custom_price'];
        $newArchive['creation_date'] = $oldPrice['created_at'];
        $newArchive->save();
    }
}