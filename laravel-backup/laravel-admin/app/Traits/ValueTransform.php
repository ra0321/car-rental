<?php

namespace App\Traits;
use Carbon\Carbon;

/**
 * Trait ValueTransform
 * @package App\Traits
 */
trait ValueTransform
{
    /**
     * @param $notice
     * @return int
     */
    public function noticeTransform($notice)
    {
        switch($notice){
            case($notice === '1 hour'):
                $value = 1;
                break;
            case($notice === '2 hours'):
                $value = 2;
                break;
            case($notice === '3 hours'):
                $value = 3;
                break;
            case($notice === '6 hours'):
                $value = 6;
                break;
            case($notice === '12 hours'):
                $value = 12;
                break;
            case($notice === '1 day'):
                $value = 24;
                break;
            case($notice === '2 days'):
                $value = 48;
                break;
            case($notice === '3 days'):
                $value = 72;
                break;
            case($notice === '1 week'):
                $value = 168;
                break;
            default:
                $value = 1;
        }
        return $value;
    }

    /**
     * @param $shortestTrip
     * @param $request
     * @return int
     */
    public function shortestTrip($shortestTrip, $request = null)
    {
        if(isset($request)){
            $sample = Carbon::parse($request['price_from_date']);
            $start_date_carbon = Carbon::parse($request['price_from_date']);
        }else{
            $sample = Carbon::now();
            $start_date_carbon = Carbon::now();
        }

        switch($shortestTrip){
            case($shortestTrip === '1 day'):
                $value = 1;
                break;
            case($shortestTrip === '2 days'):
                $value = 2;
                break;
            case($shortestTrip === '3 days'):
                $value = 3;
                break;
            case($shortestTrip === '5 days'):
                $value = 5;
                break;
            case($shortestTrip === '1 week'):
                $value = 7;
                break;
            case($shortestTrip === '2 weeks'):
                $value = 14;
                break;
            case($shortestTrip === '1 month'):
                $end = $start_date_carbon->addMonths(1);
                $value = $end->diffInDays($sample);
                break;
            default:
                $value = 0;
        }
        return $value;
    }

    /**
     * @param $longestTrip
     * @param $request
     * @return int
     */
    public function longestTrip($longestTrip, $request = null)
    {
        if(isset($request)){
            $sample = Carbon::parse($request['price_from_date']);
            $start_date_carbon = Carbon::parse($request['price_from_date']);
        }else{
            $sample = Carbon::now();
            $start_date_carbon = Carbon::now();
        }

        switch($longestTrip){
            case($longestTrip === '3 days'):
                $value = 3;
                break;
            case($longestTrip === '5 days'):
                $value = 5;
                break;
            case($longestTrip === '1 week'):
                $value = 7;
                break;
            case($longestTrip === '2 weeks'):
                $value = 14;
                break;
            case($longestTrip === '1 month'):
                $end = $start_date_carbon->addMonths(1);
                $value = $end->diffInDays($sample);
                break;
            case($longestTrip === '3 months'):
                $end = $start_date_carbon->addMonths(3);
                $value = $end->diffInDays($sample);
                break;
            default:
                $value = 10000000;
        }
        return $value;
    }

	/**
	 * @param $km
	 *
	 * @return int
	 */
	public function kmPerDay($km)
    {
        switch($km){
            case('100'):
                $km = 100;
                break;
            case('200'):
                $km = 200;
                break;
            case('300'):
                $km = 300;
                break;
            case('400'):
                $km = 400;
                break;
            case('unlimited'):
                $km = 500;
                break;
        }
        return $km;
    }

	/**
	 * @param $km
	 *
	 * @return int
	 */
	public function kmPerWeek($km)
    {
        switch($km){
            case('700'):
                $km = 700;
                break;
            case('1400'):
                $km = 1400;
                break;
            case('2100'):
                $km = 2100;
                break;
            case('2800'):
                $km = 2800;
                break;
            case('unlimited'):
                $km = 3500;
                break;
        }
        return $km;
    }

	/**
	 * @param $km
	 *
	 * @return int
	 */
	public function kmPerMonth($km)
    {
        switch($km){
            case('3000'):
                $km = 3000;
                break;
            case('6000'):
                $km = 6000;
                break;
            case('9000'):
                $km = 9000;
                break;
            case('12000'):
                $km = 12000;
                break;
            case('unlimited'):
                $km = 15000;
                break;
        }
        return $km;
    }
}
