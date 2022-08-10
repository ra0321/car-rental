<?php

namespace App\Events\Expiration;

use App\User;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class DriverLicenceExpiredEvent
 * @package App\Events\Expiration
 */
class DriverLicenceExpiredEvent
{
    use Dispatchable;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * DriverLicenceExpiredEvent constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user)
    {
        $this->user = $user;
    }
}
