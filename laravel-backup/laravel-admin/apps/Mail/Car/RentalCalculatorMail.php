<?php

namespace App\Mail\Car;

use App\RentalCalculator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class RentalCalculatorMail
 * @package App\Mail\Car
 */
class RentalCalculatorMail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var RentalCalculator
	 */
	public $rental;

	/**
	 * RentalCalculatorMail constructor.
	 *
	 * @param RentalCalculator $rental
	 */
	public function __construct(RentalCalculator $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('اذا شغلت سيارتك مع إيسار  سوف تحصل على؟')->view('emails.RentalCalculator');
    }
}
