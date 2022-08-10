<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TripBills[] $bills
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Car[] $car
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Trip[] $owner
 * @property-read \App\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Trip[] $trip
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string $password
 * @property string|null $country_code
 * @property string|null $phone_number
 * @property int $email_verified
 * @property int $phone_verified
 * @property int $approved_to_drive
 * @property int $id_verified
 * @property string|null $sms_code
 * @property string|null $verify_email_token
 * @property int|null $is_facebook
 * @property int|null $friends_count
 * @property int|null $is_google
 * @property int $listed
 * @property int $reviewed
 * @property int $count_stars
 * @property float|null $stars_as_renter
 * @property int $reviewed_as_owner
 * @property int $count_stars_as_owner
 * @property float|null $stars_as_owner
 * @property float|null $user_stars
 * @property int $trips
 * @property int $car_trips
 * @property int $count_penalty_renter
 * @property int $count_penalty_owner
 * @property int $count_penalty_in_period
 * @property int|null $penalty_amount
 * @property string|null $penalty_period
 * @property int $sms_notifications
 * @property int $email_promotions
 * @property int|null $transmission_expert
 * @property string|null $work_from_time
 * @property string|null $work_until_time
 * @property int $is_working_time
 * @property int|null $payment
 * @property string|null $bank_name
 * @property string|null $holder_name
 * @property string|null $iban
 * @property string|null $account_number
 * @property int $is_bank_account
 * @property string|null $promo_code
 * @property int|null $promo_code_used
 * @property int $user_active_status
 * @property int $admin_delete
 * @property string|null $deleting_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $bills_count
 * @property-read int|null $car_count
 * @property-read int|null $notifications_count
 * @property-read int|null $owner_count
 * @property-read int|null $trip_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdminDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereApprovedToDrive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCarTrips($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountPenaltyInPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountPenaltyOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountPenaltyRenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountStarsAsOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailPromotions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFriendsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsWorkingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereListed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePenaltyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePenaltyPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePromoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePromoCodeUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereReviewedAsOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSmsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSmsNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStarsAsOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStarsAsRenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTransmissionExpert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTrips($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserActiveStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerifyEmailToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWorkFromTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereWorkUntilTime($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DriverLicence[] $driverLicenceCard
 * @property-read int|null $driver_licence_card_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ID_Card[] $idCard
 * @property-read int|null $id_card_count
 */
class User extends Authenticatable
{
    use Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number',
        'country_code', 'authy_id', 'verify_email_token', 'email_promotions',
        'sms_notifications', 'transmission_expert', 'is_facebook', 'friends_count',
        'is_google', 'bank_name', 'holder_name', 'iban', 'account_number', 'user_active_status', 'admin_delete', 'deleting_time', 'id_verified', 'approved_to_drive'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'authy_id', 'verify_email_token',
    ];

    /**
     * Eager load the counts every time.
     *
     * @var array
     */
    protected $withCount = ['car'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function note(){
        return $this->hasMany('\App\User_note', 'user_id', 'id')->latest('created_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function car()
    {
        return $this->hasMany(Car::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trip()
    {
        return $this->hasMany(Trip::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function bills()
	{
        return $this->hasManyThrough('App\TripBills', 'App\Trip', 'owner_id')->where('status', 'finished');
    }

    /**
     * @return mixed
     */
    public function earnings()
	{
        return $this->bills->where('esar_paid', 0)->sum('owner_earning');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function owner()
    {
        return $this->hasMany(Trip::class, 'owner_id')->where('status', 'finished');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function idCard()
    {
        return $this->hasMany(ID_Card::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function driverLicenceCard()
    {
        return $this->hasMany(DriverLicence::class);
    }

    public function scopeSearchId($query, $s)
    {
        if ($s) $query->where('id', 'like', '%'.$s.'%');
    }

    public function scopeVerifiedUnverifiedUsers($query, $s){
        if ($s == 1) {
            $query->whereHas('idCard')
            ->whereHas('driverLicenceCard')
            ->where('phone_number', '!=', null)
            ->whereNotNull('phone_number')
            ->where('phone_number','!=', '')
			->where('approved_to_drive', true)
			->where('id_verified', true);
            // ->where('id_verified', $s);
        }else{
            $query->doesntHave('idCard')
            ->ordoesntHave('driverLicenceCard')
			->where('approved_to_drive', false)
			->orWhere('id_verified', false);
            // ->orWhere('id_verified', $s);
        }
    }

    public function scopeActiveInActiveUsers($query, $s){
        if ($s == 1) {
            $query->where('phone_number', '!=', null)
            ->whereNotNull('phone_number')
            ->where('phone_number','!=', '');
			// ->whereHas('idCard')
            // ->whereHas('driverLicenceCard');
            
        }else{
            $query->orWhere('phone_number', null)
            ->orWhereNull('phone_number')
            ->orWhere('phone_number', '');
			// ->doesntHave('idCard')
            // ->ordoesntHave('driverLicenceCard');
        }
    }

    public function scopeSearchFirstName($query, $s)
    {
        if ($s) $query->orWhere('first_name', 'like', '%'.$s.'%');
    }

    public function scopeSearchLastName($query, $s)
    {
        if ($s) $query->orWhere('last_name', 'like', '%'.$s.'%');
    }

    public function scopeSearchEmail($query, $s)
    {
        if ($s) $query->orWhere('email', 'like', '%'.$s.'%');
    }
    public function scopeSearchPhone($query, $s)
    {
        if ($s) $query->orWhere('phone_number', 'like', '%'.$s.'%');
    }
    public function scopeSearchActive($query, $s)
    {
        // dd($query->where('user_active_status', $s)->count());
        if ($s) $query->where('user_active_status', $s);
    }

    public function scopeSearchDateRange($query, $s)
    {
        if (!empty($s)) $query->whereBetween('created_at', $s);
    }



    public function scopeSearchBankName($query, $s)
    {
        if ($s) $query->orWhere('bank_name', 'like', '%'.$s.'%');
    }

    public function scopeSearchIban($query, $s)
    {
        if ($s) $query->orWhere('iban', 'like', '%'.$s.'%');
    }
    public function scopeSearchAccountNumber($query, $s)
    {
        if ($s) $query->orWhere('account_number', 'like', '%'.$s.'%');
    }

    public function scopeActiveUser($query, $s)
    {
        if ($s) $query->where('user_active_status', $s);
    }
    public function scopeVerifiedUser($query, $s)
    {
        // dd(isset($s) && $s == 0);
        if(isset($s) && $s == 0){
            // dd($query->orWhere('id_verified', 0)->count());
            $query->orWhere('id_verified', $s);
        }
        else{
            // dd($query->where('id_verified', $s)->count());
            $query->where('id_verified', $s);
        }
    }

    public function scopeSearchAll($query, $s){
        if($s){
            $query->where('id', 'like', '%'.$s.'%')
                ->orWhere('first_name', 'like', '%'.$s.'%')
                ->orWhere('last_name', 'like', '%'.$s.'%')
                ->orWhere('email', 'like', '%'.$s.'%')
                ->orWhere('phone_number', 'like', '%'.$s.'%');
        }
    }

    public function scopeChunkData($query){
        $downloadableData = [];
        $query->orderBy('id', 'ASC')->chunk(1000, function($users) use (&$downloadableData)
        {   
            foreach($users as $user){
                array_push($downloadableData, $user);
            }
        });
        return $downloadableData;
    }
}
