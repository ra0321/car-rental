<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class VerifyEmail
 * @package App\Mail
 */
class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * VerifyEmail constructor.
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
        return $this->subject('Verification Email')->view('emails.VerifyEmail');
    }
}
