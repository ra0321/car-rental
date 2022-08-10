<?php

namespace App\Traits\Trip;

use App\Exceptions\CustomException;
use App\TempTrip;
use App\Trip;
use DB;

/**
 * Trait TempTripTrait
 * @package App\Traits\Trip
 */
trait TempTripTrait
{
    /**
     * @param Trip $trip
     * @return Trip
     * @throws CustomException
     */
    public function returnToOldTrip(Trip $trip)
    {
        $oldTrip = TempTrip::findOrFail($trip->id);
        $oldTripArray = $oldTrip->toArray();
        try{
            DB::beginTransaction();
            foreach($oldTripArray as $key => $value){
                $trip[$key] = $value;
            }
            $trip['renter_confirm_trip_update'] = 1;
            $trip['owner_confirm_trip_update'] = 'auto_rejected';
            $trip['is_trip_modified'] = true;
            $trip->save();
            $oldTrip->delete();
            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            throw new CustomException(SOMETHING_WENT_WRONG);
        }
        return $trip;
    }
}