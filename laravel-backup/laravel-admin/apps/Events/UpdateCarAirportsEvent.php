<?php

namespace App\Events;

use App\Car;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UpdateCarAirportsEvent
 * @package App\Events
 */
class UpdateCarAirportsEvent
{
    use Dispatchable;

	/**
	 * @var
	 */
	public $location, $car;

	/**
	 * UpdateCarAirportsEvent constructor.
	 *
	 * @param $location
	 * @param Car $car
	 */
	public function __construct($location, Car $car)
    {
        $this->location = $location;
        $this->car = $car;
    }
}
