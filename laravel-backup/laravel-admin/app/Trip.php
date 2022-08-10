<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use carbon\Carbon;
/**
 * App\Trip
 *
 * @property-read \App\Car $car
 * @property-read \App\Chat $chat
 * @property-read \App\User $owner
 * @property-read \App\User $renter
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TripBills[] $tripBills
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TripImage[] $tripImages
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip query()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $chat_id
 * @property int $owner_id
 * @property int $car_id
 * @property int $renter_id
 * @property int $delivery_on_airport
 * @property int|null $airport_id
 * @property int $delivery_on_car_location
 * @property int $delivery_on_renter_location
 * @property string|null $long_location
 * @property string|null $lat_location
 * @property string|null $pickup_location
 * @property string|null $notice_time
 * @property int|null $booked_instantly
 * @property string $renter_confirm_trip
 * @property string $owner_confirm_trip
 * @property string $status
 * @property int|null $telr_cancel
 * @property int|null $renter_confirm_trip_update
 * @property string|null $owner_confirm_trip_update
 * @property int|null $telr_cancel_modification
 * @property int $trip_modified
 * @property int $is_trip_modified
 * @property int $i_agree
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $trip_bills_count
 * @property-read int|null $trip_images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereAirportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereBookedInstantly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereDeliveryOnAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereDeliveryOnCarLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereDeliveryOnRenterLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereIAgree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereIsTripModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereLatLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereLongLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereNoticeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereOwnerConfirmTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereOwnerConfirmTripUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip wherePickupLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereRenterConfirmTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereRenterConfirmTripUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereRenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereTelrCancel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereTelrCancelModification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereTripModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trip whereUpdatedAt($value)
 */
class Trip extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = [
        'price_from_date', 'price_until_date', 'pick_on_airport', 'pick_on_car_location', 'pick_on_guest_location',
        'airport_id', 'long_location', 'lat_location', 'i_agree', 'message', 'promo_code', 'activity_request_id'
	];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function note(){
        return $this->hasMany('\App\Trip_note', 'trip_id', 'id')->latest('created_at');
    }

    public function renter()
    {
    	// return $this->belongsTo('App\User', 'renter_id', 'id');
		return $this->belongsTo(User::class, 'renter_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function tripBills()
    {
        return $this->hasMany(TripBills::class);
    }

    public function tripImages()
    {
        return $this->hasMany(TripImage::class);
    }

    public function tripBill()
    {
        return $this->hasOne(TripBills::class);
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function scopeSearchId($query, $s)
    {
        if ($s) $query->orWhere('id', 'like', '%'.$s.'%');
    }
    public function scopeSearchDateRange($query, $s)
    {
        if (!empty($s)) $query->whereDate('start_date', '>=', Carbon::createFromFormat('Y-m-d', $s[0]))
                ->whereDate('end_date', '<=', Carbon::createFromFormat('Y-m-d', $s[1]));
    }

    public function scopeSearchOwners ($query, $s) {
        if($s) $query->whereHas('owner', function($q) use ($s){
            $q->where('first_name', 'like', '%'.$s.'%')
            ->orWhere('id', 'like', '%'.$s.'%')
            ->orWhere('last_name', 'like', '%'.$s.'%')
            ->orWhere('phone_number', 'like', '%'.$s.'%')
            ->orWhere('account_number', 'like', '%'.$s.'%');
        });
    }

    public function scopeSearchRenter ($query, $s) {
        if($s) $query->orWhereHas('renter', function($q) use ($s){
            $q->where('first_name', 'like', '%'.$s.'%')
            ->orWhere('id', 'like', '%'.$s.'%')
            ->orWhere('last_name', 'like', '%'.$s.'%')
            ->orWhere('phone_number', 'like', '%'.$s.'%')
            ->orWhere('account_number', 'like', '%'.$s.'%');
        });
    }

    public function scopeSearchStatus($query, $s)
    {
        if ($s) $query->orWhere('status', 'like', '%'.$s.'%');
    }


    public function scopeConfirmed($query)
    {
        $query->where('renter_confirm_trip', 'confirmed')
			->where('owner_confirm_trip', 'confirmed')
			->orWhere('booked_instantly', 1);
    }
    public function scopeCancelled($query)
    {
        $query->where('renter_confirm_trip', 'canceled')
			->orWhere('owner_confirm_trip', 'canceled')
            ->orWhere('status', 'auto_cancel');
    }
    public function scopeStarted($query)
    {
        $query->where('status', 'started');
    }
    public function scopeAutoCancelled($query)
    {
        $query->where('status', 'auto_cancel');
    }
    public function scopeWaiting($query)
    {
        $query->where('status', 'waiting');
    }
    public function scopeUnfinished($query)
    {
        $query->where('status', 'unfinished');
    }
    public function scopeFinished($query)
    {
        $query->where('status', 'finished');
    }

    public function scopePending($query)
    {
        $query->where('renter_confirm_trip', 'waiting')->orWhere('owner_confirm_trip', 'waiting');
    }

    public function scopeChunkData($query){
        $downloadableData = [];
        $query->orderBy('id', 'ASC')->chunk(100, function($users) use (&$downloadableData)
        {   
            foreach($users as $user){
                array_push($downloadableData, $user);
            }
        });
        return $downloadableData;
    }

}
