<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Profile
 *
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $id_number
 * @property string|null $id_country
 * @property string|null $id_state
 * @property string|null $id_city
 * @property string|null $dob
 * @property string|null $date_of_issue
 * @property string|null $expiration_date
 * @property string|null $issued_by
 * @property int|null $expired_id
 * @property string|null $driver_licence_number
 * @property string|null $driver_licence_date_of_issue
 * @property string|null $driver_licence_expiration_date
 * @property int|null $expired_dl
 * @property string|null $works
 * @property string|null $address
 * @property string|null $school
 * @property string|null $language
 * @property string|null $about_me
 * @property string|null $profile_photo
 * @property string|null $profile_photo_header
 * @property string|null $id_image_path
 * @property string|null $id_image_path_small
 * @property string|null $driver_licence_image_path
 * @property string|null $driver_licence_image_path_small
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereAboutMe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDriverLicenceDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDriverLicenceExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDriverLicenceImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDriverLicenceImagePathSmall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereDriverLicenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereExpiredDl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereExpiredId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereIdCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereIdCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereIdImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereIdImagePathSmall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereIdState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereProfilePhotoHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Profile whereWorks($value)
 */
class Profile extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 *
	 */
	protected $fillable = [
		'profile_photo', 'profile_photo_header', 'first_name', 'last_name', 'middle_name', 'id_country', 'id_state', 'id_city', 'id_number', 'driver_licence_number', 'dob', 'works', 'address', 'school', 'languages', 'about_me', 'user_id', 'id_image_path', 'id_image_path_small', 'driver_licence_image_path', 'driver_licence_image_path_small', 'driver_licence_expiration_date', 'driver_licence_date_of_issue'
	];

	/**
	 * @var array
	 */
	protected $hidden = [
		'id',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
