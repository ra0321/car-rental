<?php

namespace App\Events\User;

use App\User;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class CreateUser
 * @package App\Events\User
 */
class CreateUser
{
    use Dispatchable;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * CreateUser constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user)
    {
        $this->user = $user;
    }
}
