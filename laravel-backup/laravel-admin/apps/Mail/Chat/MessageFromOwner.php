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
 * Class MessageFromOwner
 * @package App\Mail\Chat
 */
class MessageFromOwner extends Mailable
{
    use Queueable, SerializesModels,  ArabicNumbers;

	/**
	 * @var
	 */
	public $chat;
	public $chatMessage;
	public $trip;
	public $owner;
	public $car;


	/**
	 * MessageFromOwner constructor.
	 *
	 * @param Chat $chat
	 */
	public function __construct(Chat $chat)
    {
        $this->trip = Trip::findOrFail($chat->trip_id);
        $this->car = Car::findOrFail($this->trip->car_id);
        $this->owner = User::findOrFail($this->trip->owner_id);
        $this->chatMessage = ChatMessage::where('chat_id', $chat->id)->orderBy('created_at', 'desc')->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('رسالة جديدة')->view('emails.otherNotifications.MessageFromOwner');
    }
}
