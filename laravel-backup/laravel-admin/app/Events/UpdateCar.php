<?php

namespace App\Events;

use App\Car;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UpdateCar
 * @package App\Events
 */
class UpdateCar
{
    use Dispatchable;

	/**
	 * @var Car
	 */
	public $car;


	/**
	 * UpdateCar constructor.
	 *
	 * @param Car $car
	 */
	public function __construct(Car $car)
    {
        $this->car = $car;
    }
}
