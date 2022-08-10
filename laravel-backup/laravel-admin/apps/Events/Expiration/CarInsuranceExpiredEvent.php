<?php

namespace App\Events\Expiration;

use App\Car;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class CarInsuranceExpiredEvent
 * @package App\Events\Expiration
 */
class CarInsuranceExpiredEvent
{
    use Dispatchable;

	/**
	 * @var Car
	 */
	public $car;

	/**
	 * CarInsuranceExpiredEvent constructor.
	 *
	 * @param Car $car
	 */
	public function __construct(Car $car)
    {
        $this->car = $car;
    }
}
