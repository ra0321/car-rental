<?php

namespace App\Listeners\Car;

use App\Airports;
use App\CarAirport;
use App\Events\Car\UpdateLocationEvent;
use App\Exceptions\CustomException;
use App\Traits\Distances;
use DB;

/**
 * Class UpdateCarLocation
 * @package App\Listeners\Car
 */
class UpdateCarLocation
{
	use Distances;
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
     * @param UpdateLocationEvent $event
     * @throws \Exception
     */
    public function handle(UpdateLocationEvent $event)
    {
        isset($event->location['long_location']) ? $event->car['long_location'] = $event->location['long_location'] : null;
        isset($event->location['lat_location']) ? $event->car['lat_location'] = $event->location['lat_location'] : null;
        isset($event->location['car_city']) ? $event->car['car_city'] = $event->location['car_city'] : null;
        isset($event->location['parking_details']) ? $event->car['parking_details'] = $event->location['parking_details'] : null;
        isset($event->location['key_hand_off']) ? $event->car['key_hand_off'] = $event->location['key_hand_off'] : null;
        try{
            DB::beginTransaction();
            $this->newLocationAirports($event);
            $event->car->save();
            DB::commit();
        }catch (\PDOException $e){
            DB::rollBack();
            throw new CustomException(SOMETHING_WENT_WRONG);
        }
    }

	/**
	 * @param $event
	 */
	private function newLocationAirports($event)
    {
    	$oldAirports = CarAirport::where('car_id', $event->car->id)->get();
    	if(count($oldAirports) > 0){
    		foreach ($oldAirports as $old_airport){
			    $old_airport->delete();
		    }
	    }
	    $airports = Airports::all()->toArray();
	    $i = 1;
	    foreach ($airports as $airport){
		    $distance = $this->locationDistances($event->location, $airport);
		    if($distance < 100 && $i < 6){
			    $carAirport = new CarAirport();
			    $carAirport['car_id'] = $event->car->id;
			    $carAirport['airport_name'] = $airport['airport_name'];
			    $carAirport['arabic_airport_name'] = $airport['arabic_airport_name'];
			    $carAirport['airport_city'] = $airport['airport_city'];
			    $carAirport['arabic_airport_city'] = $airport['arabic_airport_city'];
			    $carAirport['airport_state'] = $airport['airport_state'];
			    $carAirport['arabic_airport_state'] = $airport['arabic_airport_state'];
			    $carAirport['latitude'] = $airport['latitude'];
			    $carAirport['longitude'] = $airport['longitude'];
			    $carAirport['region'] = $airport['region'];
			    $carAirport->save();
			    $i++;
		    }
	    }
    }
}
