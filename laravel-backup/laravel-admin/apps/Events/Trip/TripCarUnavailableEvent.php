<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripCarUnavailableEvent
 * @package App\Events\Trip
 */
class TripCarUnavailableEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $data;

    /**
     * TripCarUnavailableEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
