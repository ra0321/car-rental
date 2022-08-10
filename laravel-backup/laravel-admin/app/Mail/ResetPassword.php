<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class ResetPassword
 * @package App\Mail
 */
class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * ResetPassword constructor.
	 *
	 * @param User $user
	 */
	public function __construct(User $user)
    {
    	$this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this->subject('Reset password')->view('emails.ResetPassword');
    }
}
