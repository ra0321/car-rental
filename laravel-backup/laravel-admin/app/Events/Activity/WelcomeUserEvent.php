<?php

namespace App\Events\Activity;

use App\User;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class WelcomeUserEvent
 * @package App\Events\Activity
 */
class WelcomeUserEvent
{
    use Dispatchable;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * WelcomeUserEvent constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user)
    {
        $this->user = $user;
    }
}
