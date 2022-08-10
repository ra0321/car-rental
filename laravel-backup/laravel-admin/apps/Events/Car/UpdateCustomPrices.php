<?php

namespace App\Events\Car;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UpdateCustomPrices
 * @package App\Events\Car
 */
class UpdateCustomPrices
{
    use Dispatchable;

    /**
     * @var
     */
    public $car;


    /**
     * UpdateCustomPrices constructor.
     * @param $car
     */
    public function __construct($car)
    {
        $this->car = $car;
    }
}
