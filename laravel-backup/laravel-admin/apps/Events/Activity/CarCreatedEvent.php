<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class CarCreatedEvent
 * @package App\Events\Activity
 */
class CarCreatedEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $car;

    /**
     * CarCreatedEvent constructor.
     * @param $car
     */
    public function __construct($car)
    {
        $this->car = $car;
    }
}
