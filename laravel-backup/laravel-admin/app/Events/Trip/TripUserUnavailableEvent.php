<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripUserUnavailableEvent
 * @package App\Events\Trip
 */
class TripUserUnavailableEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $data;

    /**
     * TripUserUnavailableEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
