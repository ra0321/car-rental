<?php

namespace App\Mail\Admin;

use App\CarImage;
use App\ChatMessage;
use App\Mail\Traits\DataForEmailTrait;
use App\Trip;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ModificationTripAdminMail
 * @package App\Mail\Admin
 */
class ModificationTripAdminMail extends Mailable
{
    use Queueable, SerializesModels, DataForEmailTrait;

    /**
     * @var
     */
    public $trip;
    /**
     * @var
     */
    public $tripBill;
    /**
     * @var User|User[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public $owner;
    /**
     * @var User|User[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public $renter;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public $car;
    /**
     * @var ChatMessage|\Illuminate\Database\Eloquent\Model|null
     */
    public $chatMessage;
    /**
     * @var string
     */
    public $distance;
    /**
     * @var CarImage|\Illuminate\Database\Eloquent\Model|null
     */
    public $image;
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public $airport;
    /**
     * @var string
     */
    public $startDate;
    /**
     * @var string
     */
    public $endDate;
    /**
     * @var string
     */
    public $ownerEarning;
    /**
     * @var
     */
    public $kmPerDay;
    /**
     * @var string
     */
    public $tripTotal;
    /**
     * @var string
     */
    public $phoneNumber;
    /**
     * @var string
     */
    public $countryCode;
    /**
     * @var
     */
    public $production_year;

    /**
     * ModificationTripAdminMail constructor.
     * @param Trip $trip
     */
    public function __construct(Trip $trip)
    {
        $data = $this->dataForEmail($trip);
        $this->trip = $trip;
        $this->ownerEarning = $data['ownerEarning'];
        $this->tripTotal = $data['tripTotal'];
        $this->airport = $data['airport'];
        $this->owner = $data['owner'];
        $this->renter = $data['renter'];
        $this->car = $data['car'];
        $this->chatMessage = $data['chatMessage'];
        $this->distance = $data['distance'];
        $this->image = $data['image'];
        $this->startDate = $data['startDate'];
        $this->endDate = $data['endDate'];
        $this->kmPerDay = $data['kmPerDay'];
        $this->phoneNumber = $data['phoneNumber'];
        $this->countryCode = $data['countryCode'];
        $this->production_year = $data['productionYear'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('طلب تعديل الحجز')->view('emails.admin.ModificationTripAdminMail');
    }
}
