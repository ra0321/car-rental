<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripBillEvent
 * @package App\Events\Trip
 */
class TripBillEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $data;

    /**
     * TripBillEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
