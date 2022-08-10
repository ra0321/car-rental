<?php

namespace App;

use App\Traits\Models\Mutators;
use App\Traits\Models\CustomMethods;
use App\Transformers\BookInstantlyTransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * App\BookInstantly
 *
 * @property int $id
 * @property int $car_id
 * @property int $on_car_location
 * @property int $on_airport
 * @property int $on_guest_location
 * @property int|null $delivery_fee_guest_location
 * @property int|null $max_distance
 * @property int|null $min_trip_for_free_delivery
 * @property string|null $guest_location_delivery_details
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Car $car
 * @property-read string $division
 * @property-write mixed $all_drive
 * @property-write mixed $audio_input
 * @property-write mixed $bike_rack
 * @property-write mixed $bluetooth
 * @property-write mixed $brended
 * @property-write mixed $car_is_active
 * @property-write mixed $child_seat
 * @property-write mixed $convertible
 * @property-write mixed $email_promotions
 * @property-write mixed $gps
 * @property-write mixed $have_no_car
 * @property-write mixed $hybrid
 * @property-write mixed $i_agree
 * @property-write mixed $is_automatic_price
 * @property-write mixed $is_facebook
 * @property-write mixed $is_google
 * @property-write mixed $negative_experience
 * @property-write mixed $not_earning_enough
 * @property-write mixed $other_reason
 * @property-write mixed $safety_concerns
 * @property-write mixed $ski_rack
 * @property-write mixed $sms_notifications
 * @property-write mixed $sunroof
 * @property-write mixed $toll_pass
 * @property-write mixed $too_much_work
 * @property-write mixed $transmission_expert
 * @property-write mixed $usb
 * @property-write mixed $ventilated_seat
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereDeliveryFeeGuestLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereGuestLocationDeliveryDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereMaxDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereMinTripForFreeDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereOnAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereOnCarLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereOnGuestLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-write mixed $long_term_trip
 * @property-write mixed $weekend_trip
 * @property-write mixed $inappropriate
 * @property-write mixed $misleading
 * @property-write mixed $other
 * @property-write mixed $spam
 * @property-write mixed $guest_cancel
 * @property-write mixed $promotions
 * @property-write mixed $repair
 * @property-write mixed $unavailable
 * @property-write mixed $uncomfortable
 * @property int $work_on_guest_location
 * @property-write mixed $heated_seat
 * @property-write mixed $pet_friendly
 * @property-write mixed $work_on_airport
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly whereWorkOnGuestLocation($value)
 * @property-write mixed $pick_on_airport
 * @property-write mixed $pick_on_car_location
 * @property-write mixed $pick_on_guest_location
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BookInstantly query()
 */
class BookInstantly extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = [
	    'on_car_location', 'on_airport','on_guest_location', 'delivery_fee_guest_location', 'max_distance', 'min_trip_for_free_delivery', 'guest_location_delivery_details'
    ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function car()
	{
		return $this->belongsTo(Car::class);
	}
}
