<?php

namespace App\Events\Activity;

use Illuminate\Foundation\Events\Dispatchable;
use App\User;

/**
 * Class NewMessageEvent
 * @package App\Events\Activity
 */
class NewMessageEvent
{
    use Dispatchable;

    /**
     * @var
     */
    public $user;
	/**
	 * @var
	 */
	public $chat;

	/**
	 * NewMessageEvent constructor.
	 *
	 * @param User $user
	 * @param $chat
	 */
	public function __construct(User $user, $chat)
    {
        $this->user = $user;
        $this->chat = $chat;
    }
}
