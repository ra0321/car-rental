<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ForgotPassword
 * @package App\Mail
 */
class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var
	 */
	public $user;
	/**
	 * @var
	 */
	public $password;

	/**
	 * ForgotPassword constructor.
	 *
	 * @param User $user
	 * @param      $password
	 */
	public function __construct(User $user, $password)
    {
	    $this->user = $user;
	    $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Forgot password')->view('emails.ForgotPassword');
    }
}
