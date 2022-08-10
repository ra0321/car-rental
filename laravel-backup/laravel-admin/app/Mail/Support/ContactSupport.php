<?php

namespace App\Mail\Support;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ContactSupport
 * @package App\Mail\Support
 */
class ContactSupport extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var
	 */
	public $data;

	/**
	 * ContactSupport constructor.
	 *
	 * @param $data
	 */
	public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	if(isset($this->data['attachment'])){
		    return $this->subject($this->data['title'])
		                ->view('emails.Support.contactSupport')
		                ->attach($_ENV['S3_URL'] . $this->data['attachment']);
	    }else{
		    return $this->subject($this->data['title'])
		                ->view('emails.Support.contactSupport');
	    }
    }
}
