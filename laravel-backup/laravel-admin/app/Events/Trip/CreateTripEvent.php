<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class CreateTripEvent
 * @package App\Events\Trip
 */
class CreateTripEvent 
{
    use Dispatchable;

    /**
     * @var
     */
    public $car;
    /**
     * @var
     */
    public $data;
    /**
     * @var
     */
    public $trip;


    /**
     * CreateTripEvent constructor.
     * @param $car
     * @param $data
     * @param $trip
     */
    public function __construct($car, $data, $trip)
    {
        $this->car = $car;
        $this->data = $data;
        $this->trip = $trip;
    }
}
