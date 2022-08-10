<?php

namespace App\Traits\NewPayment\TripCancellation;

use App\CarAvailable;
use App\Exceptions\CustomException;
use App\Traits\NewPayment\TripCancellation\SpecificCases\CancelTripLessThanDayTrait;
use App\Traits\NewPayment\TripCancellation\SpecificCases\CancelTripLessThanSevenDaysTrait;
use App\Traits\NewPayment\TripCancellation\SpecificCases\CancelTripMoreThanSevenDaysTrait;
use App\Traits\NewPayment\TripCancellation\SpecificCases\CancelTripWithinOneHourTrait;
use App\Trip;
use App\TripBill;
use App\User;
use App\UserAvailable;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Log;

/**
 * Trait RenterTripCancelTrait
 * @package App\Traits\NewPayment\TripCancellation
 */
trait RenterTripCancelTrait
{
    use CancelTripWithinOneHourTrait, CancelTripMoreThanSevenDaysTrait,
        CancelTripLessThanSevenDaysTrait, CancelTripLessThanDayTrait;

    /**
     * @param Trip $trip
     * @return mixed
     * @throws CustomException
     */
    public function renterCancelTrip(Trip $trip)
    {
        $tripBills = TripBill::where('trip_id', $trip->id)->orderBy('id', 'desc')->get();
        $user = User::where('id', $trip->renter_id)->first();
        $userAvailable = UserAvailable::where('user_id', $user->id)->where('trip_id', $trip->id)->first();
        $carAvailable = CarAvailable::where('car_id', $trip->car_id)->where('trip_id', $trip->id)->first();
        $now = Carbon::now();
        $hours_to_trip = Carbon::parse($trip['start_date'])->diffInHours($now);
        $withinHour = $this->withinHour($trip);

        ###############
        # FOR TESTING #
        ###############
        /*switch (true){
            case $hours_to_trip < 24 :
                $message = $this->lessThanDay($tripBills);
                break;
            case $hours_to_trip > 168 :
                $message = $this->moreThanSevenDays($tripBills);
                break;
            default:
                $message = $this->lessThanSevenDays($tripBills);
        }*/

        ########
        # LIVE #
        ########
        if($withinHour){
            $message = $this->cancelTripWithinOneHour($tripBills);
        }else{
            switch (true){
                case $hours_to_trip < 24 :
                    $message = $this->lessThanDay($tripBills);
                    break;
                case $hours_to_trip > 168 :
                    $message = $this->moreThanSevenDays($tripBills);
                    break;
                default:
                    $message = $this->lessThanSevenDays($tripBills);
            }
        }

        try{
            $user['count_penalty_renter'] += 1;
            $trip['renter_confirm_trip'] = 'canceled';
            $trip['status'] = 'canceled';
            if($trip['owner_confirm_trip_update'] === 'waiting'){
                $trip['owner_confirm_trip_update'] = 'auto_rejected';
                $trip['renter_confirm_trip_update'] = false;
            }
            $trip->save();
            $user->save();
            $userAvailable->delete();
            $carAvailable->delete();
        }catch (QueryException $exception){
            Log::emergency($exception->getMessage());
            throw new CustomException(SOMETHING_WENT_WRONG);
        }

        return $message;
    }

    /**
     * @param Trip $trip
     * @return JsonResponse
     */
    public function cancelStartedTrip(Trip $trip)
    {
        $trip['status'] = 'unfinished';
        $trip['renter_confirm_trip'] = 'shortened';
        $trip->save();
        return $this->successResponseWithMessage(OWNER_WILL_RECEIVE_EMAIL_WITH_CANCELLATION_REQUEST);
    }

    /**
     * @param Trip $trip
     * @return bool
     */
    public function withinHour(Trip $trip)
    {
        $bookedInstantly = $trip->booked_instantly;
        if($bookedInstantly){
            $minutes = $this->bookedInstantlyTime($trip);
        }else{
            $minutes = $this->requestedTripTime($trip);
        }
        if($minutes < 60){
            return true;
        }
        return false;
    }

    /**
     * @param Trip $trip
     *
     * @return int
     */
    public function bookedInstantlyTime(Trip $trip)
    {
        $now = Carbon::now();
        $tripCreated = Carbon::parse($trip->created_at);
        return $tripCreated->diffInMinutes($now);
    }

    /**
     * @param Trip $trip
     *
     * @return int
     */
    public function requestedTripTime(Trip $trip)
    {
        $now = Carbon::now();
        $tripCreated = Carbon::parse($trip->updated_at);
        return $tripCreated->diffInMinutes($now);
    }
}