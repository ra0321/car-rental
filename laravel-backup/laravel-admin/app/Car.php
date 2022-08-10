<?php

namespace App;
use carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Car
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarImage[] $carImage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Trip[] $trip
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $long_location
 * @property string $lat_location
 * @property string $car_city
 * @property string $car_manufacturer
 * @property string $car_manufacturer_arabic
 * @property string $car_model
 * @property string $production_year
 * @property string $model_class
 * @property string|null $trim
 * @property string|null $style
 * @property string $car_transmission
 * @property int $brended
 * @property string $car_value
 * @property string $vehicle_type
 * @property string $vehicle_type_arabic
 * @property string|null $car_odometer
 * @property string|null $real_odometer
 * @property int|null $deposit
 * @property float|null $count_stars
 * @property int|null $count_reviews
 * @property int|null $count_rates
 * @property int|null $count_trips
 * @property string|null $key_hand_off
 * @property string|null $parking_details
 * @property string|null $notice
 * @property string|null $car_location_notice
 * @property string|null $airport_notice
 * @property string|null $guest_location_notice
 * @property string|null $short_trip
 * @property string|null $long_trip
 * @property int $weekend_trip
 * @property int $long_term_trip
 * @property int $is_registration_car_verified
 * @property int $is_insurance_verified
 * @property int $car_is_active
 * @property int $is_deleted
 * @property int $paid_advertising
 * @property string|null $phase
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $car_image_count
 * @property-read int|null $trip_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereAirportNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereBrended($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarLocationNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarManufacturerArabic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCarValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCountRates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCountReviews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCountStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCountTrips($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereGuestLocationNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereIsInsuranceVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereIsRegistrationCarVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereKeyHandOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereLatLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereLongLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereLongTermTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereLongTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereModelClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car wherePaidAdvertising($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereParkingDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car wherePhase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereProductionYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereRealOdometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereShortTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereTrim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereVehicleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereVehicleTypeArabic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Car whereWeekendTrip($value)
 */
class Car extends Model
{
	 /**
	 *
	 * @var array
	 *
	 */
	protected $fillable = [
		'user_id', 'long_location', 'lat_location', 'car_city', 'car_manufacturer', 'car_manufacturer_arabic', 'car_model', 'car_model_id', 'model_class',
		'production_year', 'trim', 'style', 'car_transmission', 'brended', 'car_value', 'car_odometer', 'real_odometer', 'notice', 'car_location_notice', 'airport_notice',
        'guest_location_notice', 'weekend_trip', 'long_term_trip', 'short_trip', 'long_trip', 'car_is_active', 'phase', 'deposit', 'parking_details', 'key_hand_off',
        'count_stars', 'count_trips', 'count_reviews', 'is_deleted', 'is_insurance_verified', 'is_registration_car_verified'
	];

	//protected $with = ['user', 'trip'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
	
	public function userVerified()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->VerifiedUnverifiedUsers(1);
    }
	public function userUnVerified()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->VerifiedUnverifiedUsers(0);
    }
	public function userActive()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->ActiveInActiveUsers(1);
    }
	public function userInActive()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->ActiveInActiveUsers(0);
    }

    public function userHasAccount()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')
            ->where('account_number', '!=', null)
            ->where('phone_number', '!=', null);
    }

    public function trip()
    {
        return $this->hasMany(Trip::class);
    }

    public function carImage()
    {
        return $this->hasMany(CarImage::class);
    }

    public function carFeature()
	{
		return $this->hasOne(CarFeature::class);
    }
    
    public function additionalFeature()
	{
		return $this->hasMany(AdditionalFeature::class);
    }
    
    public function carFaq()
	{
		return  $this->hasMany(CarFaq::class);
    }

    public function carRestriction()
	{
		return $this->hasOne(CarRestriction::class);
    }

    public function carUnlisted()
	{
		return $this->hasMany(CarUnlisted::class);
    }

    public function bookInstantly()
	{
		return $this->hasOne(BookInstantly::class);
    }


    public function carAvailable()
    {
        return $this->hasMany(CarAvailable::class);
    }


    public function carAirport()
    {
        return $this->hasMany(CarAirport::class);
    }
    /**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function carRegistration()
	{
		return $this->hasMany(CarRegistration::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function carInsurance()
	{
		return $this->hasMany(CarInsurance::class);
    }
    
	
    public function scopeVerifiedUnverified ($query, $s) {

        if ($s == 1) {
            $query->where('is_insurance_verified', 1)
			->whereHas('userVerified')
            ->whereHas('carInsurance')
            ->whereHas('carRegistration')
            ->where('is_registration_car_verified', 1);
        }else{
            $query->whereHas('carInsurance')
            ->whereHas('carRegistration')
            ->whereHas('userVerified')
            ->where('is_insurance_verified', 0)
            ->orWhere('is_registration_car_verified', 0);
        }

    }

    public function scopeProspectListed ($query, $s) {

        if ($s == 1) {
            $query->whereHas('carInsurance')
            ->whereHas('carRegistration')
            ->whereHas('userVerified')
            ->where('is_insurance_verified', 1)
            ->where('is_registration_car_verified', 1);
        }else{
            $query->whereHas('userActive')
			->doesntHave('carInsurance')
            ->ordoesntHave('carRegistration');
        }

    }
	
	public function scopeValid ($query, $s) {

        if ($s == 1) {
            $query->join('car_registrations as cr', 'cr.car_id', 'cars.id')
			->join('car_insurances as ci', 'ci.car_id', 'cars.id')
            // ->where('cr.expiration_date','>', Carbon::today())
            // ->where('ci.expiration_date', '>', Carbon::today());
			->whereRaw("STR_TO_DATE(cr.expiration_date,'%Y-%m-%d') > ?", date('Y-m-d'))
			->whereRaw("STR_TO_DATE(ci.expiration_date,'%Y-%m-%d') > ?", date('Y-m-d'))
			->select('cars.user_id', 'cars.id',
					'cars.long_location', 
					'cars.lat_location', 
					'cars.car_city', 
					'cars.car_manufacturer', 
					'cars.car_manufacturer_arabic', 
					'cars.car_model',
					'cars.model_class',
					'cars.production_year', 
					'cars.trim', 
					'cars.style', 
					'cars.car_transmission', 
					'cars.brended', 
					'cars.car_value', 
					'cars.car_odometer', 
					'cars.real_odometer', 
					'cars.notice', 
					'cars.car_location_notice', 
					'cars.airport_notice',
					'cars.guest_location_notice', 
					'cars.weekend_trip', 
					'cars.long_term_trip', 
					'cars.short_trip', 
					'cars.long_trip', 
					'cars.car_is_active', 
					'cars.phase', 
					'cars.deposit', 
					'cars.parking_details', 
					'cars.key_hand_off',
					'cars.count_stars', 
					'cars.count_trips', 
					'cars.count_reviews', 
					'cars.is_deleted', 
					'cars.is_insurance_verified', 
					'cars.is_registration_car_verified',
					'cars.created_at', 
					'cars.updated_at');
        }else{
            $query->join('car_registrations as cr', 'cr.car_id', 'cars.id')
			->join('car_insurances as ci', 'ci.car_id', 'cars.id')
            // ->whereDate('cr.expiration_date','<=', Carbon::today())
            // ->orWhereDate('ci.expiration_date','<=', Carbon::today())
			->whereRaw("STR_TO_DATE(cr.expiration_date,'%Y-%m-%d') <= ?", date('Y-m-d'))
			->orWhereRaw("STR_TO_DATE(cr.expiration_date,'%Y-%m-%d') <= ?", date('Y-m-d'))
			->select('cars.user_id', 'cars.id',
					'cars.long_location', 
					'cars.lat_location', 
					'cars.car_city', 
					'cars.car_manufacturer', 
					'cars.car_manufacturer_arabic', 
					'cars.car_model', 
					'cars.model_class',
					'cars.production_year', 
					'cars.trim', 
					'cars.style', 
					'cars.car_transmission', 
					'cars.brended', 
					'cars.car_value', 
					'cars.car_odometer', 
					'cars.real_odometer', 
					'cars.notice', 
					'cars.car_location_notice', 
					'cars.airport_notice',
					'cars.guest_location_notice', 
					'cars.weekend_trip', 
					'cars.long_term_trip', 
					'cars.short_trip', 
					'cars.long_trip', 
					'cars.car_is_active', 
					'cars.phase', 
					'cars.deposit', 
					'cars.parking_details', 
					'cars.key_hand_off',
					'cars.count_stars', 
					'cars.count_trips', 
					'cars.count_reviews', 
					'cars.is_deleted', 
					'cars.is_insurance_verified', 
					'cars.is_registration_car_verified',
					'cars.created_at', 
					'cars.updated_at');
        }
		// dd($now = Carbon::now());
		// dd(Carbon::today());

    }

    // public function scopeSearchFirstName($query, $s)
    // {
    //     if ($s) $query->leftjoin('users', 'users.id', 'cars.user_id')->where('first_name', 'like', '%'.$s.'%');
    // }

    // public function scopeSearchLastName($query, $s)
    // {
    //     if ($s) $query->leftjoin('users', 'users.id', 'cars.user_id')->orWhere('last_name', 'like', '%'.$s.'%');
    // }

    // public function scopeSearchEmail($query, $s)
    // {
    //     if ($s) $query->leftjoin('users', 'users.id', 'cars.user_id')->orWhere('email', 'like', '%'.$s.'%');
    // }
    // public function scopeSearchPhone($query, $s)
    // {
    //     if ($s) $query->leftjoin('users', 'users.id', 'cars.user_id')->orWhere('phone_number', 'like', '%'.$s.'%');
    // }
    // public function scopeSearchActive($query, $s)
    // {
    //     if ($s) $query->leftjoin('users', 'users.id', 'cars.user_id')->orWhere('status', true);
    // }


    // Table values
    public function scopeSearchCarManufacturer($query, $s)
    {
        if ($s) $query->orWhere('car_manufacturer', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarId($query, $s)
    {
        if ($s) $query->orWhere('cars.id', 'like', '%'.$s.'%');
    }

    public function scopeSearchCarModel($query, $s)
    {
        if ($s) $query->orWhere('car_model', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarProdYear($query, $s)
    {
        if ($s) $query->orWhere('production_year', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarModelClass($query, $s)
    {
        if ($s) $query->orWhere('model_class', 'like', '%'.$s.'%');
    }
    public function scopeSearchCarCity($query, $s)
    {
        if ($s) $query->orWhere('car_city', 'like', '%'.$s.'%');
    }

    public function scopeSearchDateRange($query, $s)
    {
        if (!empty($s)) $query->whereBetween('created_at', $s);
    }
    public function scopeSearchActive($query, $s)
    {
        if ($s) $query->where('car_is_active', $s);
    }


    public function scopeStrictSearch($query, $s) {
        if ($s){ $query->where('car_is_active', $s)
            ->where('car_model', 'like', '%'.$s.'%')
            ->where('production_year', 'like', '%'.$s.'%')
            ->where('model_class', 'like', '%'.$s.'%')
            ->where('car_city', 'like', '%'.$s.'%');
        }
    }

    public function scopeFlexSearch($query, $s) {
        if ($s){ $query->whereHas('user', function($q) use($s) {
                $q->where('first_name', 'like', '%'.$s.'%')
                ->orWhere('id', 'like', '%'.$s.'%')
                ->orWhere('last_name', 'like', '%'.$s.'%')
                ->orWhere('email', 'like', '%'.$s.'%')
                ->orWhere('phone_number', 'like', '%'.$s.'%');
            })->orWhere('car_model', 'like', '%'.$s.'%')
            ->orWhere('production_year', 'like', '%'.$s.'%')
            ->orWhere('model_class', 'like', '%'.$s.'%')
            ->orWhere('car_city', 'like', '%'.$s.'%')
            ->orWhere('id', 'like', '%'.$s.'%')
            ->orWhere('car_manufacturer', 'like', '%'.$s.'%')
            ->orWhere('car_city', 'like', '%'.$s.'%');
        }
        // dd($query->count());
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
