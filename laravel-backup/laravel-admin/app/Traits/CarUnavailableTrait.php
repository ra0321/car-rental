<?php
namespace App\Traits;

use App\Car;
use App\CarAvailable;
use App\Exceptions\CustomException;
use App\User;
use App\UserAvailable;
use Carbon\Carbon;
use Log;

/**
 * Trait CarUnavailableTrait
 * @package App\Traits
 */
trait CarUnavailableTrait
{

    /**
     * @param $interval
     * @param $car
     * @throws CustomException
     */
    /*public function calculateDates($interval, $car)
    {
        $dates = CarAvailable::whereCarId($car->id)->get();
        $unavailableFrom = $interval['from'];
        $unavailableUntil = $interval['until'];
        foreach($dates as $date){
            if(Carbon::parse($unavailableFrom)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_to']))){
                throw new CustomException(CAR_IS_ALREADY_UNAVAILABLE_IN_THAT_PERIOD);
            }
            if(Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableUntil)->lte(Carbon::parse($date['unavailable_to']))){
                throw new CustomException(CAR_IS_ALREADY_UNAVAILABLE_IN_THAT_PERIOD);
            }
	        if(Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_from']))
	           && Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_to']))){
		        throw new CustomException(CAR_IS_ALREADY_UNAVAILABLE_IN_THAT_PERIOD);
	        }
        }
    }*/

    /**
     * @param $interval
     * @param $user
     * @throws CustomException
     */
    /*public function userCalculateAvailableDates($interval, $user)
    {
        $dates = UserAvailable::where('user_id', $user->id)->get();
        $unavailableFrom = $interval['from'];
        $unavailableUntil = $interval['until'];
        foreach($dates as $date){
            if(Carbon::parse($unavailableFrom)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_to']))){
                throw new CustomException(YOU_ALREADY_HAVE_TRIP_IN_THE_SAME_PERIOD);
            }
            if(Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableUntil)->lte(Carbon::parse($date['unavailable_to']))){
                throw new CustomException(YOU_ALREADY_HAVE_TRIP_IN_THE_SAME_PERIOD);
            }
	        if(Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_from']))
	           && Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_to']))){
		        throw new CustomException(YOU_ALREADY_HAVE_TRIP_IN_THE_SAME_PERIOD);
	        }
        }
    }*/

    /**
     * @param $interval
     * @param $car
     * @return bool
     */
    /*public function checkAvailability($interval, $car)
    {
        $dates = CarAvailable::whereCarId($car->id)->get();
        $unavailableFrom = $interval['from'];
        $unavailableUntil = $interval['until'];
        foreach($dates as $date){
            if(Carbon::parse($unavailableFrom)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_to']))){
                return false;
            }
            if(Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableUntil)->lte(Carbon::parse($date['unavailable_to']))){
                return false;
            }
	        if(Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_from']))
	           && Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_to']))){
		        return false;
	        }
        }
        return true;
    }*/

    /**
     * @param $interval
     * @param $car
     * @return bool
     */
    public function checkCarAvailability($interval, $car)
    {
        $dates = CarAvailable::whereCarId($car['carId'])->get();
        $unavailableFrom = $interval['start_date'];
        $unavailableUntil = $interval['end_date'];
        foreach($dates as $date){
            if(Carbon::parse($unavailableFrom)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_to']))){
                return false;
            }
            if(Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_from']))
                && Carbon::parse($unavailableUntil)->lte(Carbon::parse($date['unavailable_to']))){
                return false;
            }
	        if(Carbon::parse($unavailableFrom)->lte(Carbon::parse($date['unavailable_from']))
	           && Carbon::parse($unavailableUntil)->gte(Carbon::parse($date['unavailable_to']))){
		        return false;
	        }
        }
        return true;
    }

	/**
	 * @param $car
	 *
	 * @return CarAvailable[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function getSnoozedUnlistedUnavailable($car)
    {
        return CarAvailable::whereCarId($car->id)
            ->whereIn('status', ['snoozed', 'unlisted'])
            ->get();
    }

	/**
	 * @param $data
	 * @param $car
	 *
	 * @throws CustomException
	 */
	public function checkHours($data, $car)
    {
    	$user = User::findOrFail($car->user_id);
    	$tripFrom = strtotime(Carbon::parse($data['price_from_date'])->format('H:i:s'));
    	$tripUntil = strtotime(Carbon::parse($data['price_until_date'])->format('H:i:s'));
    	$ownerWorkFrom = strtotime($user->work_from_time);
    	$ownerWorkUntil = strtotime($user->work_until_time);
    	$from = $tripFrom >= $ownerWorkFrom && $tripFrom <= $ownerWorkUntil;
    	$until = $tripUntil >= $ownerWorkFrom && $tripUntil <= $ownerWorkUntil;

    	if(!$from || !$until){
            throw new CustomException(CAR_OWNER_IS_NOT_AVAILABLE_IN_THAT_PERIOD_OF_DAY);
        }
    }

    /**
     * @param $data
     * @param $model
     * @throws CustomException
     */
    public function isAvailable($data, $model)
    {
        $tripInterval = $this->createIntervalArray($data);
        $this->compareDates($tripInterval, $model);
        /*foreach($tripInterval as $tripDate){
            $newDate = Carbon::createFromTimestamp($tripDate)->toDateTimeString();
            if($model instanceof Car){
                $dates = CarAvailable::whereCarId($model->id)->where(function($q) use ($newDate){
                    $q->whereRaw('? between unavailable_from and unavailable_to', [$newDate]);
                })->get();
                if(count($dates) > 0){
                    $message = CAR_IS_ALREADY_UNAVAILABLE_IN_THAT_PERIOD;
                    continue;
                }
            }else{
                $dates = UserAvailable::whereUserId($model->id)->where(function($q) use ($newDate){
                    $q->whereRaw('? between unavailable_from and unavailable_to', [$newDate]);
                })->get();
                if(count($dates) > 0){
                    $message = YOU_ALREADY_HAVE_TRIP_IN_THE_SAME_PERIOD;
                    continue;
                }
            }
        }
        if(isset($message)){
            throw new CustomException($message);
        }*/
    }

    /**
     * @param $data
     * @param $model
     * @throws CustomException
     */
    public function isAvailableForUpdate($data, $model)
    {
        $oldTripInterval = $this->makeIntervalForUpdateTrip($data, $data['trip']);
        $newTripInterval = $this->makeIntervalForUpdateTrip($data);
        $dates = array_diff($newTripInterval, $oldTripInterval);
        if($dates){
            $this->compareDates($dates, $model);
        }
    }

    /**
     * @param $interval
     * @param $model
     * @throws CustomException
     */
    private function compareDates($interval, $model)
    {
        foreach($interval as $date){
            $newDate = Carbon::createFromTimestamp($date)->toDateTimeString();
            if($model instanceof Car){
                $dates = CarAvailable::whereCarId($model->id)->where(function($q) use ($newDate){
                    $q->whereRaw('? between unavailable_from and unavailable_to', [$newDate]);
                })->get();
                if(count($dates) > 0){
                    $message = CAR_IS_ALREADY_UNAVAILABLE_IN_THAT_PERIOD;
                    continue;
                }
            }else{
                $dates = UserAvailable::whereUserId($model->id)->where(function($q) use ($newDate){
                    $q->whereRaw('? between unavailable_from and unavailable_to', [$newDate]);
                })->get();
                if(count($dates) > 0){
                    $message = YOU_ALREADY_HAVE_TRIP_IN_THE_SAME_PERIOD;
                    continue;
                }
            }
        }
        if(isset($message)){
            throw new CustomException($message);
        }
    }
}