<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripSaveTripCarEvent
 * @package App\Events\Trip
 */
class TripSaveTripCarEvent 
{
    use Dispatchable;

    /**
     * @var
     */
    public $data;

    /**
     * TripSaveTripCarEvent constructor
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
