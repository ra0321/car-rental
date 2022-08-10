<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripBillUpdateEvent
 * @package App\Events\Trip
 */ 
class TripBillUpdateEvent 
{
    use Dispatchable;

    /**
     * @var
     */
    public $data;

    /**
     * TripBillUpdateEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
