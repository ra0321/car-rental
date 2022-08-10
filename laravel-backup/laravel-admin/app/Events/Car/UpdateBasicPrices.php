<?php

namespace App\Events\Car;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UpdateBasicPrices
 * @package App\Events\Car
 */
class UpdateBasicPrices
{
    use Dispatchable;

    /**
     * @var
     */
    public $allPrices;

    /**
     * @var
     */
    public $car;


    /**
     * UpdateBasicPrices constructor.
     * @param $allPrices
     * @param $car
     */
    public function __construct($allPrices, $car)
    {
        $this->allPrices = $allPrices;
        $this->car = $car;
    }
}
