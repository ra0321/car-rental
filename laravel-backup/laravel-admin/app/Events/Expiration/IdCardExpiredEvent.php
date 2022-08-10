<?php

namespace App\Events\Expiration;

use App\User;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class IdCardExpiredEvent
 * @package App\Events\Expiration
 */
class IdCardExpiredEvent
{
    use Dispatchable;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * IdCardExpiredEvent constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user)
    {
        $this->user = $user;
    }
}
