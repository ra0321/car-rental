<?php

namespace App\Listeners\Car;

use App\CarFeature;
use App\Events\Car\ListCar;

class CarFeatureEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ListCar  $event
     * @return void
     */
    public function handle(ListCar $event)
    {
        $carFeature = new CarFeature();
        $carFeature->car_id = $event->car->id;
        $carFeature->model_seats = isset($event->features['model_seats']) ? $event->features['model_seats'] : null;
        $carFeature->model_doors = isset($event->features['model_doors']) ? $event->features['model_doors'] : null;
        $carFeature->model_engine_fuel = isset($event->features['model_engine_fuel']) ? $event->features['model_engine_fuel'] : null;
        $carFeature->model_lkm_city = isset($event->features['model_lkm_city']) ? $event->features['model_lkm_city'] : null;
        $carFeature->model_lkm_hwy = isset($event->features['model_lkm_hwy']) ? $event->features['model_lkm_hwy'] : null;
        $carFeature->save();
    }
}
