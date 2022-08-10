<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripTempMessageEvent
 * @package App\Events\Trip
 */
class TripTempMessageEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $data;

    /**
     * TripTempMessageEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
