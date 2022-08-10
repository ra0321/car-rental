<?php

namespace App\Mail\TripMail;

use App\CarAirport;
use App\Traits\Arabic\ArabicNumbers;
use App\Trip;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class AcceptModificationTripRenterMail
 * @package App\Mail\TripMail
 */
class AcceptModificationTripRenterMail extends Mailable
{
    use Queueable, SerializesModels, ArabicNumbers;

	/**
	 * @var Trip
	 */
	public $trip;
    public $owner;
    public $airport;

	/**
	 * AcceptModificationTripRenterMail constructor.
	 *
	 * @param Trip $trip
	 */
	public function __construct(Trip $trip)
    {
        $this->trip = $trip;
        $this->owner = User::with('profile')->findOrFail($trip->owner_id);
        if(isset($trip->airport_id)){
            $this->airport = CarAirport::findOrFail($trip->airport_id);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('طلب تعديل الحجز تم تأكيده')->view('emails.trip.AcceptModificationRenterMail');
    }
}
