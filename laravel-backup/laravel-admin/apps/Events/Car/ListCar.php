<?php

namespace App\Events\Car;

use App\Car;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class ListCar
 * @package App\Events\Car
 */
class ListCar
{
    use Dispatchable;

    /**
     * @var Car
     */
    public $car;

    /**
     * @var
     */
    public $request;

    /**
     * @var
     */
    public $features;

    /**
     * ListCar constructor.
     * @param Car $car
     * @param $request
     * @param $features
     */
    public function __construct(Car $car, $request, $features)
    {
        $this->car = $car;
        $this->request = $request;
        $this->features = $features;
    }
}
