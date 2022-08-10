<?php

namespace App\Traits;

use Carbon\Carbon;

/**
 * Trait CreateIntervalsTrait
 * @package App\Traits
 */
trait CreateIntervalsTrait
{
    /**
     * @param $data
     * @return array
     */
    public function createIntervalArray($data)
    {
        $days[0] = Carbon::parse($data['price_from_date'])->addHours(2)->getTimestamp();
        while(end($days) + 86400 < Carbon::parse($data['price_until_date'])->getTimestamp()){
            $newDate = end($days) + 86400;
            array_push($days, $newDate);
        }
        return $days;
    }

    public function makeIntervalForUpdateTrip($data, $trip = null)
    {
        if(isset($trip)){
            $startDate = $trip['start_date'];
            $endDate = $trip['end_date'];
        }else{
            $startDate = $data['price_from_date'];
            $endDate = $data['price_until_date'];
        }
        $days[0] = Carbon::parse($startDate)->addHours(2)->getTimestamp();
        while(end($days) + 86400 < Carbon::parse($endDate)->getTimestamp()){
            $newDate = end($days) + 86400;
            array_push($days, $newDate);
        }
        return $days;
    }
}