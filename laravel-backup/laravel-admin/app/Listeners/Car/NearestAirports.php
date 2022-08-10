<?php

namespace App\Listeners\Car;

use App\Airports;
use App\CarAirport;
use App\Events\Car\ListCar;
use App\Traits\Distances;

class NearestAirports
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
     * Handle the event.
     *
     * @param  ListCar  $event
     * @return void
     */
    public function handle(ListCar $event)
    {
        $airports = Airports::all()->toArray();
        $i = 1;
        foreach ($airports as $airport){
            $distance = $this->locationDistances($event->request, $airport);
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
