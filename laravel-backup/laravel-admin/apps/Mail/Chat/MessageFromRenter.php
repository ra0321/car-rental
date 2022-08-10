<?php

namespace App\Mail\Chat;

use App\Car;
use App\Chat;
use App\ChatMessage;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PushNotification;

/**
 * Class MessageFromRenter
 * @package App\Mail\Chat
 */
class MessageFromRenter extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

	/**
	 * @var
	 */
	public $chat;
	public $trip;
	public $renter;
	public $car;
    public $chatMessage;

	/**
	 * MessageFromRenter constructor.
	 *
	 * @param Chat $chat
	 */
	public function __construct(Chat $chat)
    {
        $this->trip = Trip::findOrFail($chat->trip_id);
        $this->car = Car::findOrFail($this->trip->car_id);
        $this->renter = User::findOrFail($this->trip->renter_id);
	    $this->chatMessage = ChatMessage::where('chat_id', $chat->id)->orderBy('created_at', 'desc')->first();


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('رسالة جديدة')->view('emails.otherNotifications.MessageFromRenter');
    }
}
