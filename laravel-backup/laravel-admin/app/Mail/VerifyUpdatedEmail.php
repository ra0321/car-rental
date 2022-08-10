<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class VerifyUpdatedEmail
 * @package App\Mail
 */
class VerifyUpdatedEmail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var
	 */
	public $user;
	/**
	 * @var
	 */
	public $email_token;

	/**
	 * VerifyUpdatedEmail constructor.
	 *
	 * @param $user
	 * @param $email_token
	 */
	public function __construct($user, $email_token)
    {
        $this->user = $user;
        $this->email_token = $email_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Esar')->view('emails.VerifyUpdatedEmail');
    }
}
