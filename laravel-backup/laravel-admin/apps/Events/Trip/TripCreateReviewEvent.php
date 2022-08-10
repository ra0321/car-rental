<?php

namespace App\Events\Trip;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class TripCreateReviewEvent
 * @package App\Events\Trip
 */
class TripCreateReviewEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $data;

    /**
     * TripCreateReviewEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
