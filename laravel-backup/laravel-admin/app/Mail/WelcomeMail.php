<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class WelcomeMail
 * @package App\Mail
 */
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * WelcomeMail constructor.
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
	    return $this->subject('مرحباً بك في إيسار')->view('emails.WelcomeMail');
    }
}
