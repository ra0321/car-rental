<?php

namespace App\Mail\Car;

use App\Car;
use App\CarImage;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ListedCarMail
 * @package App\Mail\Car
 */
class ListedCarMail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User
	 */
	/**
	 * @var Car|User
	 */
	public $user, $car;
	public $image;

	/**
	 * ListedCarMail constructor.
	 *
	 * @param User $user
	 * @param Car  $car
	 */
	public function __construct(User $user, Car $car)
    {
        $this->user = $user;
        $this->car = $car;
	    $this->image = CarImage::where('car_id', $car->id)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('تم إعادة عرض السيارة')->view('emails.ListedCar');
    }
}
