<?php

namespace App\Events\Car;

use App\Car;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UpdateLocationEvent
 * @package App\Events\Car
 */
class UpdateLocationEvent
{
    use Dispatchable;

    /**
     * @var Car
     */
    public $car;
    /**
     * @var
     */
    public $location;

    /**
     * UpdateLocationEvent constructor.
     * @param Car $car
     * @param $location
     */
    public function __construct(Car $car, $location)
    {
        $this->car = $car;
        $this->location = $location;
    }
}
