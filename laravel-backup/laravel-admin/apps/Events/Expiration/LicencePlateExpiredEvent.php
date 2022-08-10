<?php

namespace App\Events\Expiration;

use App\Car;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class LicencePlateExpiredEvent
 * @package App\Events\Expiration
 */
class LicencePlateExpiredEvent
{
    use Dispatchable;

	/**
	 * @var Car
	 */
	public $car;

	/**
	 * LicencePlateExpiredEvent constructor.
	 *
	 * @param Car $car
	 */
	public function __construct(Car $car)
    {
        $this->car = $car;
    }
}
