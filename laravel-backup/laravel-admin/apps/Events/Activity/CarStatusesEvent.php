<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class CarStatusesEvent
 * @package App\Events\Activity
 */
class CarStatusesEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $carUnlisted;

    /**
     * @var
     */
    public $user;

    /**
     * CarStatusesEvent constructor.
     * @param $user
     * @param $carUnlisted
     */
    public function __construct($user, $carUnlisted)
    {
        $this->user = $user;
        $this->carUnlisted = $carUnlisted;
    }
}
