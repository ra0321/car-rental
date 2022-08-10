<?php

namespace App\Events\Car;

use App\Car;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class CarRegistrationEvent
 * @package App\Events\Car
 */
class CarRegistrationEvent
{
    use Dispatchable;

    /**
     * @var Car
     */
    public $car;
    /**
     * @var
     */
    public $data;

    /**
     * CarRegistrationEvent constructor.
     * @param Car $car
     * @param $data
     */
    public function __construct(Car $car, $data)
    {
        $this->car = $car;
        $this->data = $data;
    }
}
