<?php

namespace App\Listeners\Car;

use App\CarRestriction;
use App\Events\Car\ListCar;

class DistanceIncluded
{
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
        $distance = new CarRestriction();
        $distance['car_id'] = $event->car->id;
        $distance['km_per_day'] = '300';
        $distance['km_per_week'] = '2100';
        $distance['km_per_month'] = '9000';
        $distance['price_per_km'] = 1;
        $distance->save();
    }
}
